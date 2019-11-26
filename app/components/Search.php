<?php


namespace Components;

use NilPortugues\Sphinx\SphinxClient;

class Search
{
    protected $sphinx;

    public function __construct()
    {
        $this->sphinx = new SphinxClient();
        $this->sphinx->SetServer('localhost', 9312);
        $this->sphinx->SetConnectTimeout(1);
        $this->sphinx->SetMatchMode(SPH_MATCH_EXTENDED);

    }

    /**
     * @param string $query
     * @param string $from
     * @param int $limit
     * @return array of recipe's ids
     */
    public function query($query = '', $from = '*', $limit = 20)
    {
        $this->sphinx->setLimits(0, $limit, $limit);
        $results = $this->sphinx->query($query, $from);
        $results = $results['matches'];
        $ids = [];
        if ($results) {
            foreach ($results as $id => $item) {
                $ids[] = $id;
            }
        }
        return $ids;
    }
}