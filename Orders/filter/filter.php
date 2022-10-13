<?php

switch ($poswork) {
    /*
    case "Менеджер" :
        if (isset($_GET['start'])) {
            $date_1 = new DateTime('+7 days');
            $date_2 = new DateTime('-7 days');
            $date_1 = $date_1->format('Y-m-d');
            $date_2 = $date_2->format('Y-m-d');
            $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId 
                            FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                            INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE uorders.uId = '$id' AND  ( users.catId = 2 or users.catId = 1 )                                                                                     
                            AND orders.dateStart BETWEEN '$date_2%' AND '$date_1%' ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC ";
            return ($stringQuery);
        }

        if (isset($_GET['numorder'])) {
            if (!empty($_GET['numorder'])) {
                $numorder = $_GET['numorder'];
                $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId 
                        FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                        INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId 
                        WHERE orders.id = '$numorder' AND ( users.catId = 2 or users.catId = 1 )";
                return ($stringQuery);
            }
        }
        if (!isset($_GET['ALL_MANAGER'])) {
            $str['ALL_MANAGER'] = "uorders.uId = '" . $id . "' ";
        }
        if (isset($_GET['company'])) {
            if (!empty($_GET['company'])) {
$str['company'] = "orders.company LIKE '%" . $_GET['company'] . "%' ";
                }
        }
        if (isset($_GET['date'])) {
            if (!empty($_GET['date'])) {
                $str['date'] = "orders.deadline LIKE '" . $_GET['date'] . "%' ";
            }
        }

        if (isset($_GET['ALL'])) {
            if (!empty($_GET['ALL'])) {
                $str['all'] = "( ordstatus.status = '0' or ordstatus.status = '1' or ordstatus.status = '2' ) ";
            }
        } else {
            if (isset($_GET['Not_yet'])) {
                if (!empty($_GET['Not_yet'])) {
                    $str['not_yet'] = "ordstatus.status = 0 ";
                }
            }
            if (isset($_GET['Loading'])) {
                if (!empty($_GET['Loading'])) {
                    $str['loading'] = "ordstatus.status = 1 ";
                }
            }
            if (isset($_GET['Complete'])) {
                if (!empty($_GET['Complete'])) {
                    $str['complete'] = "ordstatus.status = 2 ";
                }
            }
        }
        if (isset($_GET['ALL_ord'])) {
            if (!empty($_GET['ALL_ord'])) {
                $str['all_ord'] = "( orders.typeTask = 'Монтаж' or orders.typeTask = 'Сборка и обработка' or orders.typeTask = 'Доставка' or orders.typeTask = 'Замеры' or orders.typeTask = 'Печать' or orders.typeTask = 'Фрезеровка' or orders.typeTask = 'Полиграфия' ) ";
            }
        } else {
            if (isset($_GET['montage'])) {
                if (!empty($_GET['montage'])) {
                    $str['montage'] = "orders.typeTask = 'Монтаж' ";
                }
            }

            if (isset($_GET['process'])) {
                if (!empty($_GET['process'])) {
                    $str['process'] = "orders.typeTask = 'Сборка и Обработка' ";
                }
            }

            if (isset($_GET['delivery'])) {
                if (!empty($_GET['delivery'])) {
                    $str['delivery'] = "orders.typeTask = 'Доставка' ";
                }
            }

            if (isset($_GET['measurements'])) {
                if (!empty($_GET['measurements'])) {
                    $str['measurements'] = "orders.typeTask = 'Замеры' ";
                }
            }
            if (isset($_GET['print'])) {
                if (!empty($_GET['print'])) {
                    $str['print'] = "orders.typeTask = 'Печать' ";
                }
            }
            if (isset($_GET['poligrafy'])) {
                if (!empty($_GET['poligrafy'])) {
                    $str['poligrafy'] = "orders.typeTask = 'Полиграфия' ";
                }
            }
            if (isset($_GET['frez'])) {
                if (!empty($_GET['frez'])) {
                    $str['frez'] = "orders.typeTask = 'Фрезеровка' ";
                }
            }
        }


        $str['query'] = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE ";
        $cnt['and'] = 0;
        if (isset($str['ALL_MANAGER'])) {
            $str['query'] = $str['query'] . $str['ALL_MANAGER'] . " AND ";
            $cnt['and']++;
        }
        if (isset($str['all'])) {
            $str['query'] = $str['query'] . $str['all'];
            $cnt['and']++;
        } else {
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['not_yet'])) {
                $str['query'] = $str['query'] . $str['not_yet'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['loading'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['loading'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['complete'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['complete'];
                $cnt['or']++;
                $cnt['and']++;
            }
            $str['query'] = $str['query'] . ") ";
        }
        if (isset($str['all_ord'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['all_ord'];
            $cnt['and']++;
        } else {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['montage'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['montage'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['delivery'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['delivery'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['process'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['process'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['measurements'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['measurements'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['print'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['print'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['frez'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['frez'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['poligrafy'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['poligrafy'];
                $cnt['or']++;
                $cnt['and']++;
            }


            $str['query'] = $str['query'] . ") ";
        }

        if (isset($str['company'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['company'];
            $cnt['and']++;
        }

        $str['query'] = $str['query'] . "AND  ( users.catId = 2 or users.catId = 1 ) ";
        if (isset($str['date'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['date'];
            $cnt['and']++;
        } else {
            if (isset($_GET['date_start']) && (isset($_GET['date_end']))) {
                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            } else {
                $date_1 = new DateTime('+1 days');
                $date_2 = new DateTime('-10 days');
                $date_1 = $date_1->format('Y-m-d');
                $date_2 = $date_2->format('Y-m-d');
                $date = date("Y-m-d");
                $date = strtotime($date);
                $_GET['date_start'] = strtotime("-14 day", $date);
                $_GET['date_end'] = strtotime("+1 day", $date);

                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND  '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            }
        }

        $str['query'] = $str['query'] . " ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC";
        $stringQuery = $str['query'];
        return ($stringQuery);
    */
    case "Начальник цеха сборки и обработки" :
        if (isset($_GET['start'])) {

            $date_1 = new DateTime('+7 days');
            $date_2 = new DateTime('-7 days');
            $date_1 = $date_1->format('Y-m-d');
            $date_2 = $date_2->format('Y-m-d');
            $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print 
                            FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                            INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE  ( users.catId = 2 or users.catId = 1 )                                                                                     
                            AND (orders.typeTask = 'Монтаж' or orders.typeTask = 'Сборка и обработка' or orders.typeTask = 'Доставка' or orders.typeTask = 'Замеры')
                            AND orders.dateStart BETWEEN '$date_2%' AND '$date_1%' ORDER BY `ordstatus`.`status` ASC, `ordstatus`.`print` ASC, `orders`.`deadline` ASC  ";
            return ($stringQuery);
        }

        if (isset($_GET['numorder'])) {
            if (!empty($_GET['numorder'])) {
                $numorder = $_GET['numorder'];
                $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print  
                        FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                        INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId 
                        WHERE orders.id = '$numorder' AND  ( users.catId = 2 or users.catId = 1 )";
                return ($stringQuery);
            }
        }
        if (isset($_GET['Manager']) && $_GET['Manager'] != "ALL_Manager") {
            $str['Manager'] = "uorders.uId = '" . $_GET['Manager'] . "' ";
        }
        if (isset($_GET['company'])) {
            if (!empty($_GET['company'])) {
                $str['company'] = "orders.company LIKE '%" . $_GET['company'] . "%' ";
            }
        }
        if (isset($_GET['date'])) {
            if (!empty($_GET['date'])) {
                $str['date'] = "orders.deadline LIKE '" . $_GET['date'] . "%' ";
            }
        }

        if (isset($_GET['ALL'])) {
            if (!empty($_GET['ALL'])) {
                $str['all'] = "( ordstatus.status = '0' or ordstatus.status = '1' or ordstatus.status = '2' ) ";
            }
        } else {
            if (isset($_GET['Not_yet'])) {
                if (!empty($_GET['Not_yet'])) {
                    $str['not_yet'] = "ordstatus.status = 0 ";
                }
            }
            if (isset($_GET['Loading'])) {
                if (!empty($_GET['Loading'])) {
                    $str['loading'] = "ordstatus.status = 1 ";
                }
            }
            if (isset($_GET['Complete'])) {
                if (!empty($_GET['Complete'])) {
                    $str['complete'] = "ordstatus.status = 2 ";
                }
            }
        }
        if (isset($_GET['ALL_ord'])) {
            if (!empty($_GET['ALL_ord'])) {
                $str['all_ord'] = "( orders.typeTask = 'Монтаж' or orders.typeTask = 'Сборка и обработка' or orders.typeTask = 'Доставка' or orders.typeTask = 'Замеры' ) ";
            }
        } else {
            if (isset($_GET['montage'])) {
                if (!empty($_GET['montage'])) {
                    $str['montage'] = "orders.typeTask = 'Монтаж' ";
                }
            }

            if (isset($_GET['process'])) {
                if (!empty($_GET['process'])) {
                    $str['process'] = "orders.typeTask = 'Сборка и Обработка' ";
                }
            }

            if (isset($_GET['delivery'])) {
                if (!empty($_GET['delivery'])) {
                    $str['delivery'] = "orders.typeTask = 'Доставка' ";
                }
            }

            if (isset($_GET['measurements'])) {
                if (!empty($_GET['measurements'])) {
                    $str['measurements'] = "orders.typeTask = 'Замеры' ";
                }
            }
            if (isset($_GET['print'])) {
                if (!empty($_GET['print'])) {
                    $str['print'] = "orders.typeTask = 'Печать' ";
                }
            }
            if (isset($_GET['poligrafy'])) {
                if (!empty($_GET['poligrafy'])) {
                    $str['poligrafy'] = "orders.typeTask = 'Полиграфия' ";
                }
            }
            if (isset($_GET['frez'])) {
                if (!empty($_GET['frez'])) {
                    $str['frez'] = "orders.typeTask = 'Фрезеровка' ";
                }
            }
        }


        $str['query'] = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE ";
        $cnt['and'] = 0;
        if (isset($str['Manager'])) {
            $str['query'] = $str['query'] . $str['Manager'] . " AND ";
            $cnt['and']++;
        }
        if (isset($str['all'])) {
            $str['query'] = $str['query'] . $str['all'];
            $cnt['and']++;
        } else {
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['not_yet'])) {
                $str['query'] = $str['query'] . $str['not_yet'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['loading'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['loading'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['complete'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['complete'];
                $cnt['or']++;
                $cnt['and']++;
            }
            $str['query'] = $str['query'] . ") ";
        }
        if (isset($str['all_ord'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['all_ord'];
            $cnt['and']++;
        } else {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['montage'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['montage'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['delivery'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['delivery'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['process'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['process'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['measurements'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['measurements'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['print'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['print'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['frez'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['frez'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['poligrafy'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['poligrafy'];
                $cnt['or']++;
                $cnt['and']++;
            }


            $str['query'] = $str['query'] . ") ";
        }

        if (isset($str['company'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['company'];
            $cnt['and']++;
        }

        $str['query'] = $str['query'] . "AND  ( users.catId = 2 or users.catId = 1 ) ";
        if (isset($str['date'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['date'];
            $cnt['and']++;
        } else {
            if (isset($_GET['date_start']) && (isset($_GET['date_end']))) {
                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            } else {
                $date_1 = new DateTime('+1 days');
                $date_2 = new DateTime('-10 days');
                $date_1 = $date_1->format('Y-m-d');
                $date_2 = $date_2->format('Y-m-d');
                $date = date("Y-m-d");
                $date = strtotime($date);
                $_GET['date_start'] = strtotime("-14 day", $date);
                $_GET['date_end'] = strtotime("+1 day", $date);

                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND  '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            }
        }

        $str['query'] = $str['query'] . " ORDER BY `ordstatus`.`status` ASC, `ordstatus`.`print` ASC, `orders`.`deadline` ASC  ";
        $stringQuery = $str['query'];
        return ($stringQuery);
    case "Полиграфия" :
        if (isset($_GET['start'])) {

            $date_1 = new DateTime('+7 days');
            $date_2 = new DateTime('-7 days');
            $date_1 = $date_1->format('Y-m-d');
            $date_2 = $date_2->format('Y-m-d');
            $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print  , orders.techTask  
                            FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                            INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE  ( users.catId = 2 or users.catId = 1 )                                                                                    
                            AND orders.typeTask = 'Полиграфия' AND orders.dateStart BETWEEN '$date_2%' AND '$date_1%' 
                            ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC ";
            return ($stringQuery);
        }

        if (isset($_GET['numorder'])) {
            if (!empty($_GET['numorder'])) {
                $numorder = $_GET['numorder'];
                $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print  , orders.techTask  
                        FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                        INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId 
                        WHERE orders.id = '$numorder' AND  ( users.catId = 2 or users.catId = 1 )";
                return ($stringQuery);
            }
        }
        if (isset($_GET['Manager']) && $_GET['Manager'] != "ALL_Manager") {
            $str['Manager'] = "uorders.uId = '" . $_GET['Manager'] . "' ";
        }
        if (isset($_GET['company'])) {
            if (!empty($_GET['company'])) {
                $str['company'] = "orders.company LIKE '%" . $_GET['company'] . "%' ";
            }
        }
        if (isset($_GET['date'])) {
            if (!empty($_GET['date'])) {
                $str['date'] = "orders.deadline LIKE '" . $_GET['date'] . "%' ";
            }
        }

        if (isset($_GET['ALL'])) {
            if (!empty($_GET['ALL'])) {
                $str['all'] = "( ordstatus.status = '0' or ordstatus.status = '1' or ordstatus.status = '2' ) ";
            }
        } else {
            if (isset($_GET['Not_yet'])) {
                if (!empty($_GET['Not_yet'])) {
                    $str['not_yet'] = "ordstatus.status = 0 ";
                }
            }
            if (isset($_GET['Loading'])) {
                if (!empty($_GET['Loading'])) {
                    $str['loading'] = "ordstatus.status = 1 ";
                }
            }
            if (isset($_GET['Complete'])) {
                if (!empty($_GET['Complete'])) {
                    $str['complete'] = "ordstatus.status = 2 ";
                }
            }
        }
        if (isset($_GET['ALL_ord'])) {
            if (!empty($_GET['ALL_ord'])) {
                $str['all_ord'] = " orders.typeTask = 'Полиграфия' ";
            }
        }


        $str['query'] = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print, orders.techTask    FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE ";
        $cnt['and'] = 0;
        if (isset($str['Manager'])) {
            $str['query'] = $str['query'] . $str['Manager'] . " AND ";
            $cnt['and']++;
        }
        if (isset($str['all'])) {
            $str['query'] = $str['query'] . $str['all'];
            $cnt['and']++;
        } else {
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['not_yet'])) {
                $str['query'] = $str['query'] . $str['not_yet'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['loading'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['loading'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['complete'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['complete'];
                $cnt['or']++;
                $cnt['and']++;
            }
            $str['query'] = $str['query'] . ") ";
        }
        if (isset($str['all_ord'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['all_ord'];
            $cnt['and']++;
        } else {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['montage'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['montage'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['delivery'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['delivery'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['process'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['process'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['measurements'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['measurements'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['print'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['print'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['frez'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['frez'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['poligrafy'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['poligrafy'];
                $cnt['or']++;
                $cnt['and']++;
            }


            $str['query'] = $str['query'] . ") ";
        }

        if (isset($str['company'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['company'];
            $cnt['and']++;
        }

        $str['query'] = $str['query'] . "AND  ( users.catId = 2 or users.catId = 1 ) ";
        if (isset($str['date'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['date'];
            $cnt['and']++;
        } else {
            if (isset($_GET['date_start']) && (isset($_GET['date_end']))) {
                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            } else {
                $date_1 = new DateTime('+1 days');
                $date_2 = new DateTime('-10 days');
                $date_1 = $date_1->format('Y-m-d');
                $date_2 = $date_2->format('Y-m-d');
                $date = date("Y-m-d");
                $date = strtotime($date);
                $_GET['date_start'] = strtotime("-14 day", $date);
                $_GET['date_end'] = strtotime("+1 day", $date);

                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND  '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            }
        }

        $str['query'] = $str['query'] . " ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC";
        $stringQuery = $str['query'];
        return ($stringQuery);
    case "Печатник" :
        if (isset($_GET['start'])) {

            $date_1 = new DateTime('+7 days');
            $date_2 = new DateTime('-7 days');
            $date_1 = $date_1->format('Y-m-d');
            $date_2 = $date_2->format('Y-m-d');
            $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print, orders.techTask  
                            FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                            INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE  ( users.catId = 2 or users.catId = 1 )                                                                                    
                            AND orders.typeTask = 'Печать' AND orders.dateStart BETWEEN '$date_2%' AND '$date_1%' ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC ";
            return ($stringQuery);
        }

        if (isset($_GET['numorder'])) {
            if (!empty($_GET['numorder'])) {
                $numorder = $_GET['numorder'];
                $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print,orders.techTask  
                        FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                        INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId 
                        WHERE orders.id = '$numorder' AND  ( users.catId = 2 or users.catId = 1 )";
                return ($stringQuery);
            }
        }
        if (isset($_GET['Manager']) && $_GET['Manager'] != "ALL_Manager") {
            $str['Manager'] = "uorders.uId = '" . $_GET['Manager'] . "' ";
        }
        if (isset($_GET['company'])) {
            if (!empty($_GET['company'])) {
                $str['company'] = "orders.company LIKE '%" . $_GET['company'] . "%' ";
            }
        }
        if (isset($_GET['date'])) {
            if (!empty($_GET['date'])) {
                $str['date'] = "orders.deadline LIKE '" . $_GET['date'] . "%' ";
            }
        }

        if (isset($_GET['ALL'])) {
            if (!empty($_GET['ALL'])) {
                $str['all'] = "( ordstatus.status = '0' or ordstatus.status = '1' or ordstatus.status = '2' ) ";
            }
        } else {
            if (isset($_GET['Not_yet'])) {
                if (!empty($_GET['Not_yet'])) {
                    $str['not_yet'] = "ordstatus.status = 0 ";
                }
            }
            if (isset($_GET['Loading'])) {
                if (!empty($_GET['Loading'])) {
                    $str['loading'] = "ordstatus.status = 1 ";
                }
            }
            if (isset($_GET['Complete'])) {
                if (!empty($_GET['Complete'])) {
                    $str['complete'] = "ordstatus.status = 2 ";
                }
            }
        }
        if (isset($_GET['ALL_ord'])) {
            if (!empty($_GET['ALL_ord'])) {
                $str['all_ord'] = " orders.typeTask = 'Печать' ";
            }
        }


        $str['query'] = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print,orders.techTask  FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE ";
        $cnt['and'] = 0;
        if (isset($str['Manager'])) {
            $str['query'] = $str['query'] . $str['Manager'] . " AND ";
            $cnt['and']++;
        }
        if (isset($str['all'])) {
            $str['query'] = $str['query'] . $str['all'];
            $cnt['and']++;
        } else {
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['not_yet'])) {
                $str['query'] = $str['query'] . $str['not_yet'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['loading'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['loading'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['complete'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['complete'];
                $cnt['or']++;
                $cnt['and']++;
            }
            $str['query'] = $str['query'] . ") ";
        }
        if (isset($str['all_ord'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['all_ord'];
            $cnt['and']++;
        } else {
            if (isset($str['print'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['print'];
                $cnt['or']++;
                $cnt['and']++;
            }
            $str['query'] = $str['query'] . ") ";
        }

        if (isset($str['company'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['company'];
            $cnt['and']++;
        }

        $str['query'] = $str['query'] . "AND  ( users.catId = 2 or users.catId = 1 ) ";
        if (isset($str['date'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['date'];
            $cnt['and']++;
        } else {
            if (isset($_GET['date_start']) && (isset($_GET['date_end']))) {
                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            } else {
                $date_1 = new DateTime('+1 days');
                $date_2 = new DateTime('-10 days');
                $date_1 = $date_1->format('Y-m-d');
                $date_2 = $date_2->format('Y-m-d');
                $date = date("Y-m-d");
                $date = strtotime($date);
                $_GET['date_start'] = strtotime("-14 day", $date);
                $_GET['date_end'] = strtotime("+1 day", $date);

                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND  '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            }
        }

        $str['query'] = $str['query'] . " ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC";
        $stringQuery = $str['query'];
        return ($stringQuery);
    case "Фрезеровщик" :
        if (isset($_GET['start'])) {

            $date_1 = new DateTime('+7 days');
            $date_2 = new DateTime('-7 days');
            $date_1 = $date_1->format('Y-m-d');
            $date_2 = $date_2->format('Y-m-d');
            $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print, orders.material, orders.thickness,orders.techTask
                            FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                            INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE  ( users.catId = 2 or users.catId = 1 )                                                                                     
                            AND orders.typeTask = 'Фрезеровка' AND orders.dateStart BETWEEN '$date_2%' AND '$date_1%' ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC ";
            return ($stringQuery);
        }

        if (isset($_GET['numorder'])) {
            if (!empty($_GET['numorder'])) {
                $numorder = $_GET['numorder'];
                $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print, orders.material, orders.thickness,orders.techTask
                        FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                        INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId 
                        WHERE orders.id = '$numorder' AND  ( users.catId = 2 or users.catId = 1 )";
                return ($stringQuery);
            }
        }
        if (isset($_GET['Manager']) && $_GET['Manager'] != "ALL_Manager") {
            $str['Manager'] = "uorders.uId = '" . $_GET['Manager'] . "' ";
        }
        if (isset($_GET['company'])) {
            if (!empty($_GET['company'])) {
                $str['company'] = "orders.company LIKE '%" . $_GET['company'] . "%' ";
            }
        }
        if (isset($_GET['date'])) {
            if (!empty($_GET['date'])) {
                $str['date'] = "orders.deadline LIKE '" . $_GET['date'] . "%' ";
            }
        }

        if (isset($_GET['ALL'])) {
            if (!empty($_GET['ALL'])) {
                $str['all'] = "( ordstatus.status = '0' or ordstatus.status = '1' or ordstatus.status = '2' ) ";
            }
        } else {
            if (isset($_GET['Not_yet'])) {
                if (!empty($_GET['Not_yet'])) {
                    $str['not_yet'] = "ordstatus.status = 0 ";
                }
            }
            if (isset($_GET['Loading'])) {
                if (!empty($_GET['Loading'])) {
                    $str['loading'] = "ordstatus.status = 1 ";
                }
            }
            if (isset($_GET['Complete'])) {
                if (!empty($_GET['Complete'])) {
                    $str['complete'] = "ordstatus.status = 2 ";
                }
            }
        }
        if (isset($_GET['ALL_ord'])) {
            if (!empty($_GET['ALL_ord'])) {
                $str['all_ord'] = " orders.typeTask = 'Фрезеровка' ";
            }
        }
        if (isset($_GET['select_material'])) {
            if ($_GET['select_material'] != "Все виды материала") {
                $str['select_material'] = " orders.material = '" . $_GET['select_material'] . "' ";
            }

        }
        if (isset($_GET['select_thickness'])) {
            if ($_GET['select_thickness'] != "Все виды толщины" && $_GET['select_thickness'] != "Указывается в т.з.") {
                $str['select_thickness'] = "AND orders.thickness = '" . $_GET['select_thickness'] . "' ";
            }
        }


        $str['query'] = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print, orders.material, orders.thickness,orders.techTask   FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE ";
        $cnt['and'] = 0;
        if (isset($str['Manager'])) {
            $str['query'] = $str['query'] . $str['Manager'] . " AND ";
            $cnt['and']++;
        }
        if (isset($str['all'])) {
            $str['query'] = $str['query'] . $str['all'];
            $cnt['and']++;
        } else {
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['not_yet'])) {
                $str['query'] = $str['query'] . $str['not_yet'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['loading'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['loading'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['complete'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['complete'];
                $cnt['or']++;
                $cnt['and']++;
            }
            $str['query'] = $str['query'] . ") ";
        }
        if (isset($str['all_ord'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['all_ord'];
            $cnt['and']++;
        } else {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['frez'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['frez'];
                $cnt['or']++;
                $cnt['and']++;
            }


            $str['query'] = $str['query'] . ") ";
        }
        if (isset($str['select_material'])) {

            if ($cnt['and'] > 0) {

                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['select_material'];
            $cnt['and']++;

        }
        if (isset($str['select_thickness'])) {
            if ($cnt[' and '] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt[' and '] = 0;
            }
            $str['query'] = $str['query'] . $str['select_thickness'];
            $cnt[' and ']++;

        }

        $str['query'] = $str['query'] . "AND  ( users.catId = 2 or users.catId = 1 ) ";
        if (isset($str['date'])) {
            if ($cnt[' and '] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt[' and '] = 0;
            }
            $str['query'] = $str['query'] . $str['date'];
            $cnt[' and ']++;
        } else {
            if (isset($_GET['date_start']) && (isset($_GET['date_end']))) {
                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . " % ' AND '" . $_GET['date_end'] . " % ' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt[' and ']++;
            } else {
                $date_1 = new DateTime(' + 1 days');
                $date_2 = new DateTime(' - 10 days');
                $date_1 = $date_1->format('Y - m - d');
                $date_2 = $date_2->format('Y - m - d');
                $date = date("Y-m-d");
                $date = strtotime($date);
                $_GET['date_start'] = strtotime("-14 day", $date);
                $_GET['date_end'] = strtotime("+1 day", $date);

                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . " % ' AND  '" . $_GET['date_end'] . " % ' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt[' and ']++;
            }
        }

        $str['query'] = $str['query'] . " ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC";
        $stringQuery = $str['query'];
        return ($stringQuery);
    /*
      case "Директор":

          if (isset($_GET['start'])) {
              $date_1 = new DateTime('+7 days');
              $date_2 = new DateTime('-7 days');
              $date_1 = $date_1->format('Y-m-d');
              $date_2 = $date_2->format('Y-m-d');
              $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId
                              FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id
                              INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE ( users.catId = 2 or users.catId = 1 )
                              AND orders.dateStart BETWEEN '$date_2%' AND '$date_1%' ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC ";
              return ($stringQuery);
          }

          if (isset($_GET['numorder'])) {
              if (!empty($_GET['numorder'])) {
                  $numorder = $_GET['numorder'];
                  $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId
                          FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id
                          INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId
                          WHERE orders.id = '$numorder' AND  ( users.catId = 2 or users.catId = 1 )";
                  return ($stringQuery);
              }
          }
          if (!isset($_GET['ALL_MANAGER'])) {
              $str['ALL_MANAGER'] = "uorders.uId = '" . $id . "' ";
          }
          if (isset($_GET['company'])) {
              if (!empty($_GET['company'])) {
                  $str['company'] = "orders.company = '" . $_GET['company'] . "' ";
              }
          }
          if (isset($_GET['date'])) {
              if (!empty($_GET['date'])) {
                  $str['date'] = "orders.deadline LIKE '" . $_GET['date'] . "%' ";
              }
          }

          if (isset($_GET['ALL'])) {
              if (!empty($_GET['ALL'])) {
                  $str['all'] = "( ordstatus.status = '0' or ordstatus.status = '1' or ordstatus.status = '2' ) ";
              }
          } else {
              if (isset($_GET['Not_yet'])) {
                  if (!empty($_GET['Not_yet'])) {
                      $str['not_yet'] = "ordstatus.status = 0 ";
                  }
              }
              if (isset($_GET['Loading'])) {
                  if (!empty($_GET['Loading'])) {
                      $str['loading'] = "ordstatus.status = 1 ";
                  }
              }
              if (isset($_GET['Complete'])) {
                  if (!empty($_GET['Complete'])) {
                      $str['complete'] = "ordstatus.status = 2 ";
                  }
              }
          }
          if (isset($_GET['ALL_ord'])) {
              if (!empty($_GET['ALL_ord'])) {
                  $str['all_ord'] = "( orders.typeTask = 'Монтаж' or orders.typeTask = 'Сборка и обработка' or orders.typeTask = 'Доставка' or orders.typeTask = 'Замеры' or orders.typeTask = 'Печать' or orders.typeTask = 'Фрезеровка' or orders.typeTask = 'Полиграфия' ) ";
              }
          } else {
              if (isset($_GET['montage'])) {
                  if (!empty($_GET['montage'])) {
                      $str['montage'] = "orders.typeTask = 'Монтаж' ";
                  }
              }

              if (isset($_GET['process'])) {
                  if (!empty($_GET['process'])) {
                      $str['process'] = "orders.typeTask = 'Сборка и Обработка' ";
                  }
              }

              if (isset($_GET['delivery'])) {
                  if (!empty($_GET['delivery'])) {
                      $str['delivery'] = "orders.typeTask = 'Доставка' ";
                  }
              }

              if (isset($_GET['measurements'])) {
                  if (!empty($_GET['measurements'])) {
                      $str['measurements'] = "orders.typeTask = 'Замеры' ";
                  }
              }
              if (isset($_GET['print'])) {
                  if (!empty($_GET['print'])) {
                      $str['print'] = "orders.typeTask = 'Печать' ";
                  }
              }
              if (isset($_GET['poligrafy'])) {
                  if (!empty($_GET['poligrafy'])) {
                      $str['poligrafy'] = "orders.typeTask = 'Полиграфия' ";
                  }
              }
              if (isset($_GET['frez'])) {
                  if (!empty($_GET['frez'])) {
                      $str['frez'] = "orders.typeTask = 'Фрезеровка' ";
                  }
              }
          }


          $str['query'] = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE ";
          $cnt['and'] = 0;
          if (isset($str['ALL_MANAGER'])) {
              $str['query'] = $str['query'] . $str['ALL_MANAGER'] . " AND ";
              $cnt['and']++;
          }
          if (isset($str['all'])) {
              $str['query'] = $str['query'] . $str['all'];
              $cnt['and']++;
          } else {
              $cnt['or'] = 0;
              $str['query'] = $str['query'] . "( ";
              if (isset($str['not_yet'])) {
                  $str['query'] = $str['query'] . $str['not_yet'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              if (isset($str['loading'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['loading'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              if (isset($str['complete'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['complete'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              $str['query'] = $str['query'] . ") ";
          }
          if (isset($str['all_ord'])) {
              if ($cnt['and'] > 0) {
                  $str['query'] = $str['query'] . "AND ";
                  $cnt['and'] = 0;
              }
              $str['query'] = $str['query'] . $str['all_ord'];
              $cnt['and']++;
          } else {
              if ($cnt['and'] > 0) {
                  $str['query'] = $str['query'] . "AND ";
                  $cnt['and'] = 0;
              }
              $cnt['or'] = 0;
              $str['query'] = $str['query'] . "( ";
              if (isset($str['montage'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['montage'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              if (isset($str['delivery'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['delivery'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              if (isset($str['process'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['process'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              if (isset($str['measurements'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['measurements'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              if (isset($str['print'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['print'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              if (isset($str['frez'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['frez'];
                  $cnt['or']++;
                  $cnt['and']++;
              }
              if (isset($str['poligrafy'])) {
                  if ($cnt['or'] > 0) {
                      $str['query'] = $str['query'] . "or ";
                      $cnt['or'] = 0;
                  }
                  $str['query'] = $str['query'] . $str['poligrafy'];
                  $cnt['or']++;
                  $cnt['and']++;
              }


              $str['query'] = $str['query'] . ") ";
          }

          if (isset($str['company'])) {
              if ($cnt['and'] > 0) {
                  $str['query'] = $str['query'] . "AND ";
                  $cnt['and'] = 0;
              }
              $str['query'] = $str['query'] . $str['company'];
              $cnt['and']++;
          }

          $str['query'] = $str['query'] . "AND  ( users.catId = 2 or users.catId = 1 )";
          if (isset($str['date'])) {
              if ($cnt['and'] > 0) {
                  $str['query'] = $str['query'] . "AND ";
                  $cnt['and'] = 0;
              }
              $str['query'] = $str['query'] . $str['date'];
              $cnt['and']++;
          } else {
              if (isset($_GET['date_start']) && (isset($_GET['date_end']))) {
                  $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND '" . $_GET['date_end'] . "%' ";
                  $str['query'] = $str['query'] . $str['between'];
                  $cnt['and']++;
              } else {
                  $date_1 = new DateTime('+1 days');
                  $date_2 = new DateTime('-10 days');
                  $date_1 = $date_1->format('Y-m-d');
                  $date_2 = $date_2->format('Y-m-d');
                  $date = date("Y-m-d");
                  $date = strtotime($date);
                  $_GET['date_start'] = strtotime("-14 day", $date);
                  $_GET['date_end'] = strtotime("+1 day", $date);

                  $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND  '" . $_GET['date_end'] . "%' ";
                  $str['query'] = $str['query'] . $str['between'];
                  $cnt['and']++;
              }
          }

          $str['query'] = $str['query'] . " ORDER BY `ordstatus`.`status` ASC , `orders`.`deadline` ASC";
          $stringQuery = $str['query'];
          return ($stringQuery);
          break;
          */
    default :

        if (isset($_GET['start'])) {
            $date_1 = new DateTime('+7 days');
            $date_2 = new DateTime('-7 days');
            $date_1 = $date_1->format('Y-m-d');
            $date_2 = $date_2->format('Y-m-d');
            $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId, ordstatus.print 
                            FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                            INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE uorders.uId = '$id' AND  ( users.catId = 2 or users.catId = 1 )                                                                                     
                            AND orders.dateStart BETWEEN '$date_2%' AND '$date_1%' ORDER BY `ordstatus`.`status` ASC, `ordstatus`.`print` ASC, `orders`.`deadline` ASC  ";
            return ($stringQuery);
        }

        if (isset($_GET['numorder'])) {
            if (!empty($_GET['numorder'])) {
                $numorder = $_GET['numorder'];
                $stringQuery = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId ,ordstatus.print 
                        FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id 
                        INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId 
                        WHERE orders.id = '$numorder' AND ( users.catId = 2 or users.catId = 1 )";
                return ($stringQuery);
            }
        }
        if (isset($_GET['Manager']) && $_GET['Manager'] != "ALL_Manager") {
            $str['Manager'] = "uorders.uId = '" . $_GET['Manager'] . "' ";
        }
        if (isset($_GET['company'])) {
            if (!empty($_GET['company'])) {
                $str['company'] = "orders.company LIKE '%" . $_GET['company'] . "%' ";
            }
        }
        if (isset($_GET['date'])) {
            if (!empty($_GET['date'])) {
                $str['date'] = "orders.deadline LIKE '" . $_GET['date'] . "%' ";
            }
        }

        if (isset($_GET['ALL'])) {
            if (!empty($_GET['ALL'])) {
                $str['all'] = "( ordstatus.status = '0' or ordstatus.status = '1' or ordstatus.status = '2' ) ";
            }
        } else {
            if (isset($_GET['Not_yet'])) {
                if (!empty($_GET['Not_yet'])) {
                    $str['not_yet'] = "ordstatus.status = 0 ";
                }
            }
            if (isset($_GET['Loading'])) {
                if (!empty($_GET['Loading'])) {
                    $str['loading'] = "ordstatus.status = 1 ";
                }
            }
            if (isset($_GET['Complete'])) {
                if (!empty($_GET['Complete'])) {
                    $str['complete'] = "ordstatus.status = 2 ";
                }
            }
        }
        if (isset($_GET['ALL_ord'])) {
            if (!empty($_GET['ALL_ord'])) {
                $str['all_ord'] = "( orders.typeTask = 'Монтаж' or orders.typeTask = 'Сборка и обработка' or orders.typeTask = 'Доставка' or orders.typeTask = 'Замеры' or orders.typeTask = 'Печать' or orders.typeTask = 'Фрезеровка' or orders.typeTask = 'Полиграфия' ) ";
            }
        } else {
            if (isset($_GET['montage'])) {
                if (!empty($_GET['montage'])) {
                    $str['montage'] = "orders.typeTask = 'Монтаж' ";
                }
            }

            if (isset($_GET['process'])) {
                if (!empty($_GET['process'])) {
                    $str['process'] = "orders.typeTask = 'Сборка и Обработка' ";
                }
            }

            if (isset($_GET['delivery'])) {
                if (!empty($_GET['delivery'])) {
                    $str['delivery'] = "orders.typeTask = 'Доставка' ";
                }
            }

            if (isset($_GET['measurements'])) {
                if (!empty($_GET['measurements'])) {
                    $str['measurements'] = "orders.typeTask = 'Замеры' ";
                }
            }
            if (isset($_GET['print'])) {
                if (!empty($_GET['print'])) {
                    $str['print'] = "orders.typeTask = 'Печать' ";
                }
            }
            if (isset($_GET['poligrafy'])) {
                if (!empty($_GET['poligrafy'])) {
                    $str['poligrafy'] = "orders.typeTask = 'Полиграфия' ";
                }
            }
            if (isset($_GET['frez'])) {
                if (!empty($_GET['frez'])) {
                    $str['frez'] = "orders.typeTask = 'Фрезеровка' ";
                }
            }
        }


        $str['query'] = "SELECT orders.id, orders.typeTask, orders.company, orders.deadline, ordstatus.status, users.name, users.catId,ordstatus.print  FROM orders INNER JOIN ordstatus on ordstatus.oId = orders.id INNER JOIN uorders on uorders.oId = orders.id INNER JOIN users on users.id = uorders.uId INNER JOIN category on category.id = users.catId WHERE ";
        $cnt['and'] = 0;
        if (isset($str['Manager'])) {
            $str['query'] = $str['query'] . $str['Manager'] . " AND ";
            $cnt['and']++;
        }
        if (isset($str['all'])) {
            $str['query'] = $str['query'] . $str['all'];
            $cnt['and']++;
        } else {
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['not_yet'])) {
                $str['query'] = $str['query'] . $str['not_yet'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['loading'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['loading'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['complete'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['complete'];
                $cnt['or']++;
                $cnt['and']++;
            }
            $str['query'] = $str['query'] . ") ";
        }
        if (isset($str['all_ord'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['all_ord'];
            $cnt['and']++;
        } else {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $cnt['or'] = 0;
            $str['query'] = $str['query'] . "( ";
            if (isset($str['montage'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['montage'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['delivery'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['delivery'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['process'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['process'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['measurements'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['measurements'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['print'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['print'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['frez'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['frez'];
                $cnt['or']++;
                $cnt['and']++;
            }
            if (isset($str['poligrafy'])) {
                if ($cnt['or'] > 0) {
                    $str['query'] = $str['query'] . "or ";
                    $cnt['or'] = 0;
                }
                $str['query'] = $str['query'] . $str['poligrafy'];
                $cnt['or']++;
                $cnt['and']++;
            }


            $str['query'] = $str['query'] . ") ";
        }

        if (isset($str['company'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['company'];
            $cnt['and']++;
        }

        $str['query'] = $str['query'] . "AND  ( users.catId = 2 or users.catId = 1 ) ";
        if (isset($str['date'])) {
            if ($cnt['and'] > 0) {
                $str['query'] = $str['query'] . "AND ";
                $cnt['and'] = 0;
            }
            $str['query'] = $str['query'] . $str['date'];
            $cnt['and']++;
        } else {
            if (isset($_GET['date_start']) && (isset($_GET['date_end']))) {
                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            } else {
                $date_1 = new DateTime('+1 days');
                $date_2 = new DateTime('-10 days');
                $date_1 = $date_1->format('Y-m-d');
                $date_2 = $date_2->format('Y-m-d');
                $date = date("Y-m-d");
                $date = strtotime($date);
                $_GET['date_start'] = strtotime("-14 day", $date);
                $_GET['date_end'] = strtotime("+1 day", $date);

                $str['between'] = "AND orders.dateStart BETWEEN '" . $_GET['date_start'] . "%' AND  '" . $_GET['date_end'] . "%' ";
                $str['query'] = $str['query'] . $str['between'];
                $cnt['and']++;
            }
        }


        $str['query'] = $str['query'] . " ORDER BY `ordstatus`.`status` ASC ,`ordstatus`.`print` ASC, `orders`.`deadline` ASC";
        $stringQuery = $str['query'];
        return ($stringQuery);
}
