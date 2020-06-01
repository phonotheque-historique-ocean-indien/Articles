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
    private $plugin_path;
    # -------------------------------------------------------
    # Constructor
    # -------------------------------------------------------

    public function __construct(&$po_request, &$po_response, $pa_view_paths = null)
    {
        parent::__construct($po_request, $po_response, $pa_view_paths);
        $this->plugin_path = __CA_APP_DIR__ . '/plugins/Articles';

        $this->opo_config = Configuration::load(__CA_APP_DIR__ . '/plugins/Articles/conf/articles.conf');

        // Extracting theme name to properly handle views in distinct theme dirs
        $vs_theme_dir = explode("/", $po_request->getThemeDirectoryPath());
        $vs_theme = end($vs_theme_dir);
        $this->opa_view_paths[] = $this->plugin_path."/themes/".$vs_theme."/views";
    }

    # -------------------------------------------------------
    # Functions to render views
    # -------------------------------------------------------
    public function Index($type = "")
    {
        // Detecting through Session if we are in "partie froide" or "partie chaude"
        session_start();
        if(filter_var($_GET["partie"], FILTER_SANITIZE_STRING) == "froide") {
            $_SESSION["partie"] = "froide";
        }
        if($_SESSION["partie"] == "froide") {
            $this->response->setRedirect(caNavUrl($this->request, "", "Phonotheque", "Partenaires"));
        }
        // Get  all the pages
        $pages = ca_site_pages::getPageList();
        // Reordering to have the newest at the beginning
        $pages = array_reverse($pages);

        // Getting only the first 3 of those
        $pages = array_slice($pages, 0, 3);

	    $blocks = "";
        // Limit to the 3 last ids
        foreach($pages as $page) {
            $vt_page = new ca_site_pages($page["page_id"]);
            $article = $vt_page->get("content");
            $this->view->setVar("article", $article);
            $this->view->setVar("id", $page["page_id"]);
            $this->view->setVar("template_title", $page["template_title"]);
            $blocks .= $this->render("front/front_block_html.php", true);
        }
        //$page = new ca_site_pages(1);
        $this->view->setVar("blocks", $blocks);
        $this->render('front/front_page_html.php');
    }
}
?>
