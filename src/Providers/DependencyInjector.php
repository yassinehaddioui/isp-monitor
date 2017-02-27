<?php
/**
 * Created by -
 * User: yassinehaddioui
 * Date: 2/26/17
 * Time: 2:55 PM
 */

namespace IspMonitor\Providers;


class DependencyInjector
{

    public static function initializeContainer($container)
    {
        $container['renderer'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getRenderer();
        };

        $container['logger'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getLogger();
        };

        $container['authService'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getAuthService();
        };

        $container['errorHandler'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getErrorHandler();
        };

        $container['dataService'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getMongoDataService();
        };

        $container['cachingService'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getCachingService();
        };

        $container['reservationService'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getReservationService();
        };

        $container['eventService'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getEventService();
        };

        $container['reservationRepository'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getReservationRepository();
        };

        $container['eventRepository'] = function ($c) {
            /** @var ServiceProvider $provider */
            $provider = $c['serviceProvider'];
            return $provider->getEventRepository();
        };

        return $container;
    }

}