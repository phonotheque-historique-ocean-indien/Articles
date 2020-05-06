<?php
ini_set("display_errors", 1);
error_reporting(E_ERROR);
require_once(__CA_MODELS_DIR__.'/ca_site_pages.php');

class FrontController extends ActionController
{
    # -------------------------------------------------------
    protected $opo_config;        // plugin configuration file
    protected $opa_list_of_lists; // list of lists
    protected $opa_listIdsFromIdno; // list of lists
    protected $opa_locale; // locale id
    private $opo_list;
    # -------------------------------------------------------
    # Constructor
    # -------------------------------------------------------

    public function __construct(&$po_request, &$po_response, $pa_view_paths = null)
    {
        parent::__construct($po_request, $po_response, $pa_view_paths);

        $this->opo_config = Configuration::load(__CA_APP_DIR__ . '/plugins/Articles/conf/articles.conf');

    }

    # -------------------------------------------------------
    # Functions to render views
    # -------------------------------------------------------
    public function Index($type = "")
    {
	    $blocks = "";
        for($id=1;$id<=3;$id++) {
            $page = new ca_site_pages($id);
            $article = $page->get("content");
            $this->view->setVar("article", $article);
            $this->view->setVar("id", $id);
            $blocks .= $this->render("home_block_html.php", true);
        }
        //$page = new ca_site_pages(1);
        $this->view->setVar("blocks", $blocks);
        $this->render('front/front_page_html.php');
    }
}
?>
