$(function () {
    $('.steps-block').sortable({
        handle: ".draggable",
        // containment: 'parent',
        placeholder: 'sortable-placeholder',
        axis: 'y',
        start: function (event, ui) {
            let handler = ui.helper.find('.draggable').first();
            handler.addClass('active');
            $('.step-item').addClass('short').css('height', 'auto');
            ui.item.data('start-pos', ui.item.index() + 1);
            ui.placeholder.height((ui.item.height() - 100));
            $(this).sortable('refreshPositions');

        },
        stop: function (event, ui) {
            let handler = ui.item.find('.draggable').first();
            handler.removeClass('active');
            $('.step-item').removeClass('short');
        },
        change: function (e, ui) {
            var seq,
                startPos = ui.item.data('start-pos'),
                $index,
                correction;
            correction = startPos <= ui.placeholder.index() ? 0 : 1;

            ui.item.parent().find('.step-item').each(function (idx, el) {
                var $this = $(el),
                    $index = $this.index();
                if (($index + 1 >= startPos && correction === 0) || ($index + 1 <= startPos && correction === 1)) {
                    $index = $index + correction;
                    $this.attr('data-position', $index);
                    $this.find('.step-count span').text($index);
                }
            });
            seq = ui.item.parent().find('.sortable-placeholder').index() + correction;
            ui.item.attr('data-position', seq);
            ui.item.data('position', seq);
            ui.item.find('.step-count span').text(seq);
        }
    });
    $('.steps-block').disableSelection();


});
