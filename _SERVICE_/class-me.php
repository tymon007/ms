<?php
class Me
{
    public function __construct(string $log)
    {
        global $db;
        $sql = "SELECT * FROM `users` WHERE `login` = '" . $log . "'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $me = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($me)) {
            foreach ($me[0] as $key => $val) {
                eval('$this->' . $key . ' = $me[0]["' . $key . '"];');
            }
        }
    }

    public function select(string $table, array $columns, array $condition = null, array $order = null, $limit = false)
    {
        global $db;
        $str = "SELECT ";
        for ($i = 0; $i < count($columns); $i++) {
            if ($i == (count($columns) - 1)) {
                if ($columns[$i] == "*") $str .= $columns[$i] . " ";
                else $str .= "`" . $columns[$i] . "` ";
            } else {
                if ($columns[$i] == "*") $str .= $columns[$i] . ", ";
                else $str .= "`" . $columns[$i] . "`, ";
            }
        }
        $str .= "FROM `" . $table . "`";
        if ($condition) {
            $str .= " ";
            $str .= "WHERE ";
            $col = array_keys($condition);
            $val = array_values($condition);
            for ($i = 0; $i < count($condition); $i++) {
                if (count($condition) > 1) {
                    if ($i == (count($condition) - 1)) {
                        if (is_string($val[$i])) {
                            $str .= "`" . $col[$i] . "` = '" . $val[$i] . "' ";
                        } else {
                            $str .= "`" . $col[$i] . "` = " . $val[$i];
                        }
                    } else {
                        if (is_string($val[$i])) {
                            $str .= "`" . $col[$i] . "` = '" . $val[$i] . "' AND ";
                        } else {
                            $str .= "`" . $col[$i] . "` = " . $val[$i] . " AND ";
                        }
                    }
                } else {
                    if (is_string($val[$i])) {
                        $str .= "`" . $col[$i] . "` = '" . $val[$i] . "'";
                    } else {
                        $str .= "`" . $col[$i] . "` = " . $val[$i];
                    }
                }
            }
        }
        if ($order) {
            $str .= " ORDER BY ";
            $or = array_keys($order);
            $asc = array_values($order);
            for ($i = 0; $i < count($order); $i++) {
                if ($asc[$i] == -1) {
                    if ($i == (count($or) - 1)) {
                        $str .= "`" . $or[$i] . "` DESC";
                    } else {
                        $str .= "`" . $or[$i] . "` DESC, ";
                    }
                } elseif ($asc[$i] == 0) {
                    if ($i == (count($or) - 1)) {
                        $str .= "`" . $or[$i] . "`";
                    } else {
                        $str .= "`" . $or[$i] . "`, ";
                    }
                } elseif ($asc[$i] == 1) {
                    if ($i == (count($or) - 1)) {
                        $str .= "`" . $or[$i] . "` ASC";
                    } else {
                        $str .= "`" . $or[$i] . "` ASC, ";
                    }
                }
            }
        }
        if ($limit) {
            $str .= " LIMIT " . $limit;
        }
        $stmt = $db->prepare($str);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function insert(string $table, array $col_a_val)
    {
        global $db;
        $values = array_values($col_a_val);
        $keys = array_keys($col_a_val);
        $str = "INSERT INTO `" . $table . "` (";
        for ($i = 0; $i < count($col_a_val); $i++) {
            if ($i == (count($col_a_val) - 1)) {
                $str .= "`" . $keys[$i] . "`) ";
            } else {
                $str .= "`" . $keys[$i] . "`, ";
            }
        }
        $str .= "VALUES (";
        for ($i = 0; $i < count($col_a_val); $i++) {
            if ($i == (count($col_a_val) - 1)) {
                if (is_string($values[$i])) $str .= "'" . $values[$i] . "')";
                elseif (is_null($values[$i])) $str .= "NULL)";
                else $str .= $values[$i] . ")";
            } else {
                if (is_string($values[$i])) $str .= "'" . $values[$i] . "', ";
                elseif (is_null($values[$i])) $str .= "NULL, ";
                else $str .= $values[$i] . ", ";
            }
        }
        $stmt = $db->prepare($str);
        if ($stmt->execute()) return true;
        return false;
    }

    public function update(string $table, array $col_a_val, array $condition = null, bool $ignore = false, array $order = null, $limit = false)
    {
        global $db;
        $values = array_values($col_a_val);
        $columns = array_keys($col_a_val);
        if ($ignore) $str = "UPDATE IGNORE `" . $table . "` SET ";
        else $str = "UPDATE `" . $table . "` SET ";
        for ($i = 0; $i < count($col_a_val); $i++) {
            if ($i == (count($col_a_val) - 1)) {
                if (is_string($values[$i])) $str .= "`" . $columns[$i] . "` = '" . $values[$i] . "'";
                elseif (is_null($values[$i])) $str .= "`" . $columns[$i] . "` = NULL";
                else $str .= "`" . $columns[$i] . "` = " . $values[$i];
            } else {
                if (is_string($values[$i])) $str .= "`" . $columns[$i] . "` = '" . $values[$i] . "', ";
                elseif (is_null($values[$i])) $str .= "`" . $columns[$i] . "` = NULL, ";
                else $str .= "`" . $columns[$i] . "` = " . $values[$i] . ", ";
            }
        }
        if ($condition) {
            $str .= " ";
            $str .= "WHERE ";
            $col = array_keys($condition);
            $val = array_values($condition);
            for ($i = 0; $i < count($condition); $i++) {
                if (count($condition) > 1) {
                    if ($i == (count($condition) - 1)) {
                        if (is_string($val[$i])) {
                            $str .= "`" . $col[$i] . "` = '" . $val[$i] . "' ";
                        } else {
                            $str .= "`" . $col[$i] . "` = " . $val[$i];
                        }
                    } else {
                        if (is_string($val[$i])) {
                            $str .= "`" . $col[$i] . "` = '" . $val[$i] . "' AND ";
                        } else {
                            $str .= "`" . $col[$i] . "` = " . $val[$i] . " AND ";
                        }
                    }
                } else {
                    if (is_string($val[$i])) {
                        $str .= "`" . $col[$i] . "` = '" . $val[$i] . "'";
                    } else {
                        $str .= "`" . $col[$i] . "` = " . $val[$i];
                    }
                }
            }
        }
        if ($order) {
            $str .= " ORDER BY ";
            for ($i = 0; $i < count($order); $i++) {
                if ($i == (count($order) - 1)) $str .= "`" . $order[$i] . "`";
                else $str .= "`" . $order[$i] . "`, ";
            }
        }
        if ($limit) {
            $str .= " LIMIT " . $limit;
        }
        if ($stmt = $db->exec($str)) return true;
        return false;
    }

    public function delete(string $table, array $condition = null, array $order = null, $limit = false)
    {
        global $db;
        $str = "DELETE FROM `" . $table . "`";
        if ($condition) {
            $str .= " ";
            $str .= "WHERE ";
            $col = array_keys($condition);
            $val = array_values($condition);
            for ($i = 0; $i < count($condition); $i++) {
                if (count($condition) > 1) {
                    if ($i == (count($condition) - 1)) {
                        if (is_string($val[$i])) {
                            $str .= "`" . $col[$i] . "` = '" . $val[$i] . "' ";
                        } else {
                            $str .= "`" . $col[$i] . "` = " . $val[$i];
                        }
                    } else {
                        if (is_string($val[$i])) {
                            $str .= "`" . $col[$i] . "` = '" . $val[$i] . "' AND ";
                        } else {
                            $str .= "`" . $col[$i] . "` = " . $val[$i] . " AND ";
                        }
                    }
                } else {
                    if (is_string($val[$i])) {
                        $str .= "`" . $col[$i] . "` = '" . $val[$i] . "'";
                    } else {
                        $str .= "`" . $col[$i] . "` = " . $val[$i];
                    }
                }
            }
        }
        if ($order) {
            $str .= " ORDER BY ";
            for ($i = 0; $i < count($order); $i++) {
                if ($i == (count($order) - 1)) $str .= "`" . $order[$i] . "`";
                else $str .= "`" . $order[$i] . "`, ";
            }
        }
        if ($limit) {
            $str .= " LIMIT " . $limit;
        }
        if ($stmt = $db->exec($str)) return true;
        return false;
    }
}
