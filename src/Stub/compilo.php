<?php

namespace Spip\Compilateur\Noeud {
    class Boucle {
        public $show;
        public $nom;
        public $id_boucle;
        public $id_table;
        public $primary;
        public $sql_serveur;
        public $select;
        public $from;
        public $where;
        public $descr;
        public $from_type;
        public $join;
        public $group;
        public $order;
        public $limit;
        public $having;
    }
};

namespace {
    function instituer_boucle() {}
    function calculer_select() {}
};
