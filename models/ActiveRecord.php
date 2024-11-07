<?php

namespace Model;

use InvalidArgumentException;
use PDO;

class ActiveRecord
{

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    protected static $idTabla = '';

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public static function getDB(): PDO
    {
        return self::$db;
    }

    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }
    // Validación
    public static function getAlertas()
    {
        return static::$alertas;
    }

    public function validar()
    {
        static::$alertas = [];
        return static::$alertas;
    }

    // Registros - CRUD
    public function guardar()
    {
        $resultado = '';
        $id = static::$idTabla ?? 'id';
        if (!is_null($this->$id)) {
            // actualizar
            $resultado = $this->actualizar();
        } else {
            // Creando un nuevo registro
            $resultado = $this->crear();
        }
        return $resultado;
    }

    public static function all()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultado = self::consultarSQL($query);

        // debuguear($resultado);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id = [])
    {
        $idQuery = static::$idTabla ?? 'id';
        $query = "SELECT * FROM " . static::$tabla;

        if (is_array(static::$idTabla)) {
            foreach (static::$idTabla as $key => $value) {
                if ($value == reset(static::$idTabla)) {
                    $query .= " WHERE $value = " . self::$db->quote($id[$value]);
                } else {
                    $query .= " AND $value = " . self::$db->quote($id[$value]);
                }
            }
        } else {

            $query .= " WHERE $idQuery = $id";
        }

        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Obtener Registro
    public static function get($limite)
    {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT ${limite}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    // Busqueda Where con Columna 
    public static function where($columna, $valor, $condicion = '=',  $additionalConditions = [], $orderBy = null)
    {
        // Si $columna es un array, interpretamos que es un array de condiciones
        if (is_array($columna)) {
            $conditions = $columna;
        } else {
            // De lo contrario, creamos un array con la única condición dada
            $conditions = [[$columna, $valor, $condicion]];
        }

        // Si se pasan condiciones adicionales, las agregamos al array de condiciones
        if (!empty($additionalConditions)) {
            $conditions = array_merge($conditions, $additionalConditions);
        }

        // Construimos la cláusula WHERE
        $whereClause = [];
        foreach ($conditions as $condition) {
            if (!is_array($condition) || count($condition) < 2) {
                throw new InvalidArgumentException('Cada condición debe ser un array con al menos 2 elementos: columna y valor.');
            }

            $columna = $condition[0];
            $valor = $condition[1];
            $condicion = isset($condition[2]) ? $condition[2] : '=';

            $whereClause[] = "${columna} ${condicion} '${valor}'";
        }

        $whereClauseStr = implode(' AND ', $whereClause);
        $query = "SELECT * FROM " . static::$tabla . " WHERE " . $whereClauseStr;
        if ($orderBy) {
            $query .= " ORDER BY " . $orderBy;
        }
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    // SQL para Consultas Avanzadas.
    public static function SQL($consulta)
    {
        $query = $consulta;
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // crea un nuevo registro
    public function crear()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (";
        $query .= join(", ", array_values($atributos));
        $query .= " ) ";


        // debuguear($query);

        // Resultado de la consulta
        $resultado = self::$db->exec($query);

        return [
            'resultado' =>  $resultado,
            'id' => self::$db->lastInsertId(static::$tabla)
        ];
    }

    public function actualizar()
    {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}={$value}";
        }
        $id = static::$idTabla ?? 'id';

        $query = "UPDATE " . static::$tabla . " SET ";
        $query .=  join(', ', $valores);

        if (is_array(static::$idTabla)) {

            foreach (static::$idTabla as $key => $value) {
                if ($value == reset(static::$idTabla)) {
                    $query .= " WHERE $value = " . self::$db->quote($this->$value);
                } else {
                    $query .= " AND $value = " . self::$db->quote($this->$value);
                }
            }
        } else {
            $query .= " WHERE " . $id . " = " . self::$db->quote($this->$id) . " ";
        }

        // debuguear($query);

        $resultado = self::$db->exec($query);
        return [
            'resultado' =>  $resultado,
        ];
    }

    // Eliminar un registro - Toma el ID de Active Record
    public function eliminar()
    {
        $idQuery = static::$idTabla ?? 'id';
        $query = "DELETE FROM "  . static::$tabla . " WHERE $idQuery = " . self::$db->quote($this->$idQuery);
        $resultado = self::$db->exec($query);
        return $resultado;
    }

    public static function consultarSQL($query)
    {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while ($registro = $resultado->fetch(PDO::FETCH_ASSOC)) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->closeCursor();

        // retornar los resultados
        return $array;
    }

    public static function fetchArray($query)
    {
        $data = [];
        $resultado = self::$db->query($query);
        $respuesta = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($respuesta as $value) {
            $data[] = array_change_key_case($value);
        }
        $resultado->closeCursor();
        return $data;
    }

    public static function fetchObject($query)
    {
        $data = [];
        $resultado = self::$db->query($query);
        $respuesta = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($respuesta as $value) {
            $data[] = new static(array_change_key_case($value));
        }
        $resultado->closeCursor();
        return $data;
    }

    public static function fetchFirst($query)
    {
        $data = [];
        $resultado = self::$db->query($query);
        $respuesta = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($respuesta as $value) {
            $data[] = array_change_key_case($value);
        }
        $resultado->closeCursor();
        return self::crearObjeto(array_shift($data));
    }

    public static function fetchFirstObject($query)
    {
        $data = [];
        $resultado = self::$db->query($query);
        $respuesta = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($respuesta as $value) {
            $data[] = array_change_key_case($value);
        }
        $resultado->closeCursor();
        return new static(array_shift($data));
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            $key = strtolower($key);
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }



    // Identificar y unir los atributos de la BD
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            $columna = strtolower($columna);
            if ($columna === 'id' || $columna === static::$idTabla || is_null($this->$columna)) continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->quote($value);
        }
        return $sanitizado;
    }

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    public static function joinWhere($joins = [], $conditions = [], $orderBy = null)
    {
        // Construir la cláusula JOIN
        $joinClause = '';
        foreach ($joins as $join) {
            if (!is_array($join) || count($join) < 3) {
                throw new InvalidArgumentException('Cada join debe ser un array con al menos 3 elementos: tabla, columna1 y columna2.');
            }
            list($joinTable, $joinCol1, $joinCol2, $joinType) = array_pad($join, 4, 'INNER');
            $joinClause .= " $joinType JOIN $joinTable ON $joinCol1 = $joinCol2";
        }

        // Construir la cláusula WHERE
        $whereClause = '';
        if (!empty($conditions)) {
            $whereConditions = [];
            foreach ($conditions as $condition) {
                if (!is_array($condition) || count($condition) < 2) {
                    throw new InvalidArgumentException('Cada condición debe ser un array con al menos 2 elementos: columna y valor.');
                }
                list($columna, $valor, $condicion) = array_pad($condition, 3, '=');
                $whereConditions[] = "$columna $condicion '$valor'";
            }
            $whereClause = ' WHERE ' . implode(' AND ', $whereConditions);
        }

        // Construir la consulta completa
        $query = "SELECT * FROM " . static::$tabla . $joinClause . $whereClause;

        // Agregar la cláusula ORDER BY si se especifica
        if ($orderBy) {
            $query .= " ORDER BY " . $orderBy;
        }
        $data = [];
        $resultado = self::$db->query($query);
        // Ejecutar la consulta y devolver el resultado
        $respuesta = $resultado->fetchAll(PDO::FETCH_ASSOC);
        foreach ($respuesta as $value) {
            $data[] = (object) array_change_key_case($value);
        }
        $resultado->closeCursor();
        return $data;
    }

    public static function findOrCreate($criteria, $data)
    {
        $conditions = [];
        foreach ($criteria as $key => $value) {
            $conditions[] = "$key = " . self::$db->quote($value);
        }
        $whereClause = implode(" AND ", $conditions);

        $query = "SELECT * FROM " . static::$tabla . " WHERE $whereClause";
        $result = self::consultarSQL($query);

        if ($result && count($result) > 0) {
            $existingRecord = $result[0];
            foreach ($data as $key => $value) {
                if (property_exists($existingRecord, $key)) {
                    $existingRecord->$key = $value;
                }
            }
            $existingRecord->guardar();
            return $existingRecord;
        } else {
            $newRecord = new static();
            $newRecord->sincronizar(array_merge($criteria, $data));
            $newRecord->guardar();
            $result = self::consultarSQL($query);
            return $result[0];
        }
    }
}
