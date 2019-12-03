<?php

namespace Components;

use Models\ImageType;
use Models\Media;
use Phalcon\Http\Request\File;
use Phalcon\Image\Adapter\Imagick;
use Phalcon\Mvc\User\Component;

class ImageManager extends Component
{
    public static function getRootPath()
    {
        return ROOT_PATH . '/public/img/r/';
    }

    public static function createPath($id_image)
    {
        $path = self::getRootPath();
        $image_dirs = str_split((string)$id_image);
        $path = $path . implode('/', $image_dirs);
        return mkdir($path, 0777, true);
    }

    public static function saveOriginal(File $file, $path)
    {
        $path = self::getRootPath() . $path;
        $image = new Imagick($file->getTempName());
        $image->save($path);
    }

//
    public static function resize(Media $image, $type = '')
    {
        if (!$type) {
            $image_types = ImageType::find('active=1');
        } else
            $image_types = ImageType::find([
                'conditions' => 'type = :type: AND active = 1',
                'bind' => [
                    'type' => $type
                ]
            ]);
        if (!$image_types)
            return false;
        foreach ($image_types as $image_type) {
            ImageManager::resizeForImageType($image, $image_type);
        }
        return true;
    }

    public static function resizeForImageType(Media $image, ImageType $image_type)
    {
        $image_imagick = new Imagick($image->getPath());
        if (($image_imagick->getWidth() / $image_type->getWidth()) > 1 || ($image_imagick->getHeight() / $image_type->getHeight()) > 1) {
            if ($image_imagick->getWidth() > $image_imagick->getHeight()) {
                $image_imagick->resize($image_type->getWidth(), null, \Phalcon\Image::WIDTH);
            } else {
                $image_imagick->resize(null, $image_type->getHeight(), \Phalcon\Image::HEIGHT);
            }
        }
//        $x = ($image_type->width - $image_imagick->getWidth()) / 2;
//        $y = ($image_type->height - $image_imagick->getHeight()) / 2;
//        $canvas->watermark($image_imagick, $x, $y, 100);
        $image_imagick->save($image->getPath($image_type->getType()), 90);
    }

    public static function drawWatermark($image, $force = true)
    {
        $is_file_exists = file_exists($image->getPathWithWatermark(false));
        if (!$force && $is_file_exists) {
            return true;
        }
        //get watermark params from DB
        $watermark_params = unserialize(Configuration::get('WATERMARK_PARAMS'));
        $watermark_width_procents = $watermark_params['watermark_width_procents'];
        $watermark_height_procents = $watermark_params['watermark_height_procents'];
        $x_position_procents = $watermark_params['x_position_procents'];
        $y_position_procents = $watermark_params['y_position_procents'];
        $opacity = $watermark_params['opacity'];
        $coefficient = $watermark_params['coefficient']; // coefficient = (watermark_width / watermark_height)
        //if file is not exists => return false
        try {
            $imagick_image = new \Imagick($image->getPath(''));
        } catch (\ImagickException $e) {
            return false;
        }
        //get canvas image sizes
        $imagick_image->setImageFormat("png32");
        $imagick_image_width = $imagick_image->getImageWidth();
        $imagick_image_height = $imagick_image->getImageHeight();
        //задаем альфа-канал для исходного изображения
        $imagick_image->setImageAlphaChannel(\Imagick::ALPHACHANNEL_ACTIVATE);

        $watermark = new \Imagick($_SERVER['DOCUMENT_ROOT'] . '/public/img/watermarks/watermark.png');

        //вычисляем позицию watermark в пикселях
        $x_position = (int)($x_position_procents * $imagick_image_width / 100);
        $y_position = (int)($y_position_procents * $imagick_image_height / 100);
        //вычисляем размеры watermark в пикселях
        $watermark_width = (int)($watermark_width_procents * $imagick_image_width / 100);
        $watermark_height = (int)($watermark_width / $coefficient);
        //$watermark_height = (int)($watermark_height_procents / $watermark_width_procents * $watermark_width);

        $watermark->resizeImage($watermark_width, $watermark_height, \Imagick::FILTER_UNDEFINED, 1);
        //задаем прозрачность для watermark
        $watermark->evaluateImage(\Imagick::EVALUATE_MULTIPLY, $opacity, \Imagick::CHANNEL_ALPHA);

        $imagick_image->compositeImage($watermark, \Imagick::COMPOSITE_OVER, $x_position, $y_position);
        $imagick_image->writeImage($image->getPathWithWatermark(false));
        $watermark->destroy();
        $imagick_image->destroy();
        return true;
    }

    public static function saveImageFromRemote($id_image, $force_download = true)
    {
        $image = Image::findFirst($id_image);
        if (!$force_download && file_exists($image->getPath('')) && filesize($image->getPath('')) > 1000) {
            return 'file exists';
        }
        $path = $image->getPath('');
        $remote_path = ImageManager::getImageLinkById($id_image);

        $test_url = 'http://aquamarket.ua' . $remote_path;
        $headers = @get_headers($test_url);
        if ($headers[0] == 'HTTP/1.1 404 Not Found') {
//            return 'remote file not exists';
            return false;
        }

        $link = file_get_contents('http://aquamarket.ua' . $remote_path);
        ImageManager::createPath($id_image);
        file_put_contents($path, $link);
        if (filesize($path) > 1000) {
            return true;
        } else {
            ImageManager::saveImageFromRemote($id_image, true);
        }
    }

    public static function getImageLinkById($id_image)
    {
        $id_str = (string)$id_image;
        $link = '/img/p/';
        $link .= implode('/', str_split($id_str));
        $link .= '/' . $id_str . '.jpg';
        return $link;
    }

    public static function getCaptcha($code)
    {

        $im = imageCreate(150, 70);

        $color = imagecolorallocate($im, 219, 219, 219);

        //Линии позади текста
//        $linenum = rand(2, 4);
////        $linenum = 2;
//        for ($i=0; $i<$linenum; $i++)
//        {
//            $rand_color = rand(20,60);
//            $color = imagecolorallocate($im, $rand_color,  $rand_color,  $rand_color); // Случайный цвет c изображения
//            imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
//        }
        //Цвет текста
        $color = imagecolorallocate($im, 0, 0, 0);

        //Диапазон font-size
        $sizes = [];
        for ($i = 0; $i < strlen($code); $i++) {
            $sizes [] = rand(20, 30);
        }

        //пишем текст
        $x = 0;
        for ($i = 0; $i < strlen($code); $i++) {
            $x += 25;
            $char = substr($code, $i, 1);
            imagettftext($im, $sizes[$i], rand(2, 10), $x, rand(35, 45), $color, $_SERVER['DOCUMENT_ROOT'] . '/public/fonts/arial.ttf', $char);
        }
        //Рисуем линии на тексте
//        for ($i=0; $i<$linenum; $i++)
//        {
//            $rand_color = rand(20,60);
//            $color = imagecolorallocate($im, $rand_color,  $rand_color,  $rand_color);
//            imageline($im, rand(0, 20), rand(1, 50), rand(150, 180), rand(1, 50), $color);
//        }

        return imageJpeg($im);

    }

}