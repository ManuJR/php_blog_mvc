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
            $this -> total_items = Article::getCount();
            $this -> total_pages = ceil( $this -> total_items / $this -> limit ); 
            $this -> element = $this->generatePaginator();

        }

        public function __get($name)
        {
            return $this->$name;
        }

        // función que cuente los items totales de BBDD --> rellenar el resto de props.

        private function generatePaginator(){
            $result = "<nav aria-label='...'><ul class='pagination'>";
           
            if( $this->current_page > 1 ){
                $result .= "<li class='page-item'>
                            <a class='page-link' href='".BASE_FOLDER."/page/".($this->current_page-1)."' tabindex='-1'>Previous</a>
                        </li>";
            }
            
            for ($i=1; $i <= $this->total_pages; $i++) { 

                $active = ( $i == $this->current_page ) ? 'active' : '';

                $result .= "<li class='page-item $active'> <a class='page-link' href='".BASE_FOLDER."/page/$i'>$i</a> </li>";
            }

            if( $this -> current_page < $this -> total_pages ){
                $result .= "<li class='page-item'>
                            <a class='page-link' href='".BASE_FOLDER."/page/".($this->current_page+1)."'>Next</a>
                        </li>";
            }

            $result .= "</ul></nav>";

            return $result;
        }

    }


?>