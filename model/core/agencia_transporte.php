<?php

/*
 * This file is part of facturacion_base
 * Copyright (C) 2015         Pablo Peralta
 * Copyright (C) 2015-2016    Carlos Garcia Gomez  neorazorx@gmail.com
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace FacturaScripts\model;

/**
 * Agencia de transporte de mercancías.
 * 
 * @author Carlos García Gómez <neorazorx@gmail.com>
 */
class agencia_transporte extends \fs_model {

    /**
     * Clave primaria. Varchar(8).
     * @var type 
     */
    public $codtrans;

    /**
     * Nombre de la agencia.
     * @var type 
     */
    public $nombre;
    public $telefono;
    public $web;

    /**
     * TRUE => activo.
     * @var type
     */
    public $activo;

    public function __construct($p = FALSE) {
        parent::__construct('agenciastrans');
        if ($p) {
            $this->codtrans = $p['codtrans'];
            $this->nombre = $p['nombre'];
            $this->telefono = $p['telefono'];
            $this->web = $p['web'];
            $this->activo = $this->str2bool($p['activo']);
        } else {
            $this->codtrans = NULL;
            $this->nombre = NULL;
            $this->telefono = NULL;
            $this->web = NULL;
            $this->activo = TRUE;
        }
    }

    public function install() {
        return '';
    }

    /**
     * Devuelve la url donde ver/modificar estos datos
     * @return type
     */
    public function url() {
        return "index.php?page=admin_transportes&cod=" . $this->codtrans;
    }

    /**
     * Devuelve la agencia de transporte con codtrans = $cod
     * @param type $cod
     * @return \FacturaScripts\model\agencia_transporte|boolean
     */
    public function get($cod) {
        $data = $this->db->select("SELECT * FROM " . $this->table_name . " WHERE codtrans = " . $this->var2str($cod) . ";");
        if ($data) {
            return new \agencia_transporte($data[0]);
        }
        return FALSE;
    }

    /**
     * Devuelve TRUE si la agencia existe (en la base de datos)
     * @return boolean
     */
    public function exists() {
        if (is_null($this->codtrans)) {
            return FALSE;
        }
        return $this->db->select("SELECT * FROM " . $this->table_name . " WHERE codtrans = " . $this->var2str($this->codtrans) . ";");
    }

    /**
     * Guarda los datos en la base de datos
     * @return type
     */
    public function save() {
        if ($this->exists()) {
            $sql = "UPDATE " . $this->table_name . " SET  nombre = " . $this->var2str($this->nombre)
                    . ", telefono = " . $this->var2str($this->telefono)
                    . ", web = " . $this->var2str($this->web)
                    . ", activo = " . $this->var2str($this->activo)
                    . "  WHERE codtrans = " . $this->var2str($this->codtrans) . ";";
        } else {
            $sql = "INSERT INTO " . $this->table_name . " (codtrans,nombre,telefono,web,activo)"
                    . " VALUES (" . $this->var2str($this->codtrans)
                    . "," . $this->var2str($this->nombre)
                    . "," . $this->var2str($this->telefono)
                    . "," . $this->var2str($this->web)
                    . "," . $this->var2str($this->activo) . ");";
        }

        return $this->db->exec($sql);
    }

    /**
     * Elimina la agencia de transportes (de la base de datos)
     * @return type
     */
    public function delete() {
        return $this->db->exec("DELETE FROM " . $this->table_name . " WHERE codtrans = " . $this->var2str($this->codtrans) . ";");
    }

    /**
     * Devuelve un array con todas las agencias de transporte
     * @return \FacturaScripts\model\agencia_transporte
     */
    public function all() {
        $listaa = array();

        $data = $this->db->select("SELECT * FROM " . $this->table_name . " ORDER BY nombre ASC;");
        if ($data) {
            foreach ($data as $d) {
                $listaa[] = new \agencia_transporte($d);
            }
        }

        return $listaa;
    }

}
