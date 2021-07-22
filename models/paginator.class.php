<?php
    class Paginator{

        private $current_page;
        private $limit;
        private $offset;
        private $element;

        private $total_items;
        private $total_pages;

        public function __construct( $page )
        {
            $this -> current_page = !empty($page) ? $page : 1;
            $this -> limit = 4;
            $this -> offset = ($this->current_page-1) * $this->limit;
            $this -> element = $this->generatePaginator();
        }

        public function __get($name)
        {
            return $this->$name;
        }

        // función que cuente los items totales de BBDD --> rellenar el resto de props.

        private function generatePaginator(){
            $result = "<nav aria-label='...'>
                <ul class='pagination'>
                    <li class='page-item disabled'>
                    <a class='page-link' href='#' tabindex='-1'>Previous</a>
                    </li>

                    <li class='page-item'><a class='page-link' href='#'>1</a></li>
                    <li class='page-item active'>
                    <a class='page-link' href='#'>2 <span class='sr-only'>(current)</span></a>
                    </li>
                    <li class='page-item'><a class='page-link' href='#'>3</a></li>
                    <li class='page-item'>

                    <a class='page-link' href='#'>Next</a>
                    </li>
                </ul>
		    </nav>";
            return $result;
        }


    }


?>