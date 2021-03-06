<?php
    class Restaurant
    {
        private $restaurant_name;
        private $address;
        private $keywords;
        private $cuisine_id;
        private $id;

        function __construct($restaurant_name, $address, $keywords, $cuisine_id, $id = null)
        {
            $this->restaurant_name = $restaurant_name;
            $this->address = $address;
            $this->keywords = $keywords;
            $this->cuisine_id = $cuisine_id;
            $this->id = $id;
        }

        function getRestaurantName()
        {
            return $this->restaurant_name;
        }

        function getAddress()
        {
            return $this->address;
        }

        function getKeywords()
        {
            return $this->keywords;
        }

        function getCuisineId()
        {
            return $this->cuisine_id;
        }

        function getRestaurantId()
        {
            return $this->id;
        }

        function setRestaurantName($new_name)
        {
            $this->restaurant_name = (string) $new_name;
        }

        function setRestaurantAddress($new_address)
        {
            $this->address = (string) $new_address;
        }

        function setRestaurantKeywords($new_keywords)
        {
            $this->keywords = (string) $new_keywords;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO restaurants (name, address, keywords, cuisine_id) VALUES ('{$this->getRestaurantName()}', '{$this->getAddress()}', '{$this->getKeywords()}', {$this->getCuisineId()});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants ORDER BY name;");
            $all_restaurants = array();
            foreach($returned_restaurants as $restaurant) {
                $restaurant_name = $restaurant['name'];
                $address = $restaurant['address'];
                $keywords = $restaurant['keywords'];
                $cuisine_id = $restaurant['cuisine_id'];
                $id = $restaurant['id'];
                $new_restaurant = new Restaurant($restaurant_name, $address, $keywords, $cuisine_id, $id);
                array_push($all_restaurants, $new_restaurant);
            }
            return $all_restaurants;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants;");
        }

        static function findRestaurant($search_id)
        {
            $found_restaurant = null;
            $all_restaurants = Restaurant::getAll();
            foreach ($all_restaurants as $restaurant) {
                $restaurant_id = $restaurant->getRestaurantId();
                if($restaurant_id == $search_id) {
                    $found_restaurant = $restaurant;
                }
            }
            return $found_restaurant;
        }

        function updateRestaurant($new_name, $new_address, $new_keywords)
        {
            $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}', address = '{$new_address}', keywords = '{$new_keywords}' WHERE id = {$this->getRestaurantId()};");
            $this->setRestaurantName($new_name);
            $this->setRestaurantAddress($new_address);
            $this->setRestaurantKeywords($new_keywords);
        }

        function deleteRestaurant()
        {
            $GLOBALS['DB']->exec("DELETE FROM restaurants WHERE id={$this->getRestaurantId()};");
        }
    }








?>
