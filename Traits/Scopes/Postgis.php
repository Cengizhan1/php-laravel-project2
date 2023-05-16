<?php

namespace App\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;
use MStaack\LaravelPostgis\Eloquent\PostgisTrait;
use MStaack\LaravelPostgis\Geometries\Point;

trait Postgis
{
    use PostgisTrait;

    /**
     * @param Builder $query
     * @param $column
     * @param $as
     * @param Point $location
     * @return Builder
     */
    public function scopeWithDistance(Builder $query, $column, $as, $location)
    {
        $classQuery = $query->getQuery();

        if ($classQuery && ! $classQuery->columns) {
            $query->select([$classQuery->from . '.*']);
        }

        if ($location) {
            if ($location instanceof Point) {
                $longitude = $location->getLng();
                $latitude = $location->getLat();
            } else {
                list($longitude, $latitude) = explode(",", $location);
            }

            $q = "ST_Distance({$column},ST_Point({$longitude},{$latitude}))";
        } else {
            $q = "0";
        }

        return $query->selectSub($q, $as);
    }

    /**
     * @param Builder $query
     * @param string $column
     * @param string $operator
     * @param Point $location
     * @param string $distance
     * @return Builder
     */
    public function scopeWhereDistance(Builder $query, $column, $operator, $location, $distance)
    {
        $classQuery = $query->getQuery();

        if ($classQuery && ! $classQuery->columns) {
            $query->select([$classQuery->from . '.*']);
        }

        if ($location) {
            if ($location instanceof Point) {
                $longitude = $location->getLng();
                $latitude = $location->getLat();
            } else {
                list($latitude, $longitude) = $location;
            }

            $q = "ST_Distance({$column},ST_Point({$longitude},{$latitude}))";
        } else {
            $q = "0";
        }

        return $query->whereRaw("$q {$operator} {$distance}");
    }
}
