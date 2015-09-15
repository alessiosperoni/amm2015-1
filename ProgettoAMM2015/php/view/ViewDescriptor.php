<?php

class ViewDescriptor {
 
    private $titolo;

    private $menu;

    private $leftBar;

    private $rightBar;

    private $content;

    private $pagina;
 
    private $sottoPagina;

    const get = 'get';
   
    const post = 'post';
    
    private $impostaToken;

    private $js;
 
    public function __construct() {
        $this->js = array();
    }
    
    /**
     * Restituisco il titolo della pagina
     * @return type
     */
    public function getTitolo() {
        return $this->titolo;
    }
    
    /**
     * Setto il titolo della pagina
     * @param type $titolo
     */
    public function setTitolo($titolo) {
        $this->titolo = $titolo;
    }
    
    /**
     * Restituisco il menù
     * @return type
     */
    public function getMenu() {
        return $this->menu;
    }
    
    /**
     * Setto il menù
     * @param type $menu
     */
    public function setMenu($menu) {
        $this->menu = $menu;
    }
    
    /**
     * Restituisco la barra di destra
     * @return type
     */
    public function getRightBar() {
        return $this->rightBar;
    }
    
    /**
     * Setto la barra di destra
     * @param type $rightBar
     */
    public function setRightBar($rightBar) {
        $this->rightBar = $rightBar;
    }
    
    /**
     * Restituisco la barra di sinistra
     * @return type
     */
    public function getLeftBar() {
        return $this->leftBar;
    }
    
    /**
     * Setto la barra di sinistra
     * @param type $leftBar
     */
    public function setLeftBar($leftBar) {
        $this->leftBar = $leftBar;
    }
    
    /**
     * Setto il contenuto
     * @param type $content
     */
    public function setContent($content) {
        $this->content = $content;
    }
    
    /**
     * Restituisco il contenuto
     * @return type
     */
    public function getContent() {
        return $this->content;
    }
    
    /**
     * Restituisco la sottopagina
     * @return type
     */
    public function getSottoPagina() {
        return $this->sottoPagina;
    }
    
    /**
     * Restituisco la pagina
     * @return type
     */
    public function getPagina() {
        return $this->pagina;
    }
    
       
    /**
     * Setto la sottopagina
     * @param type $pagina
     */
    public function setSottoPagina($pagina) {
        $this->sottoPagina = $pagina;
    }
    
    /**
     * Setto la pagina
     * @param type $pagina
     */
    public function setPagina($pagina) {
        $this->pagina = $pagina;
    }
    
    /**
     * Aggiungo uno script
     * @param type $nome
     */
    public function addScript($nome){
        $this->js[] = $nome;
    }
    
    /**
     * Restituisco gli scripts
     * @return type
     */
    public function &getScripts(){
        return $this->js;
    }
    
    /**
     * Imposto il token
     * @param type $token
     */
    public function setImpostaToken($token) {
        $this->impostaToken = $token;
    }
    
    /**
     * Scrittura del token
     * @param type $pre
     * @param type $method
     * @return string
     */
    public function scriviToken($pre = '', $method = self::get) {
        $nessuno = BaseController::nessuno;
        switch ($method) {
            case self::get:
                if (isset($this->impostaToken)) {
                    return $pre . "$nessuno=$this->impostaToken";
                }
                break;

            case self::post:
                if (isset($this->impostaToken)) {
                    return "<input type=\"hidden\" name=\"$nessuno\" value=\"$this->impostaToken\"/>";
                }
                break;
        }

        return '';
    }

}

?>
