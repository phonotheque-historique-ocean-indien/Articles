<?php
ini_set("display_errors", 1);
error_reporting(E_ERROR);
require_once(__CA_MODELS_DIR__.'/ca_site_pages.php');

class EditorController extends ActionController
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
            //$this->response->setRedirect(caNavUrl($this->request, "", "Phonotheque", "Partenaires"));
        }
        // Get  all the pages
        $pages = ca_site_pages::getPageList();
        // Reordering to have the newest at the beginning
        $pages = array_reverse($pages);

        $blocks = "";
        $i = 1;

        foreach($pages as $page) {
            // Limit to the 3 last ids
            if($i>3) break;

            $vt_page = new ca_site_pages($page["page_id"]);
            // Skip non published articles
            if(!$vt_page->get("access")) continue;

            $article = $vt_page->get("content");
            $this->view->setVar("article", $article);
            $this->view->setVar("id", $page["page_id"]);
            $this->view->setVar("template_title", $page["template_title"]);
            $blocks .= $this->render("front/front_block_html.php", true);
            $i++;
        }
        //$page = new ca_site_pages(1);
        $this->view->setVar("blocks", $blocks);
        $this->render('front/front_page_html.php');
    }


    public function Article() {
        $is_redactor = false;
        foreach($this->getRequest()->getUser()->getUserGroups() as $group) {
            if($group["code"] == "redactor") $is_redactor=true;
        }
        $id= $this->request->getParameter("id", pInteger);
        $force = $this->request->getParameter("force", pInteger);
        // TODO Redirect if no ID
        $page = new ca_site_pages($id);
        $this->view->setVar("page", $page);
        //$page = new ca_site_pages(1);
        $article = $page->get("content");

        $page = new ca_site_pages($id);
        $this->view->setVar("access", $page->get("access"));

        if($force) {
            $article["blocs"] = json_encode("");
        }
        $this->view->setVar("article", $article);

        $this->view->setVar("is_redactor", $is_redactor);
        $this->view->setVar("id", $id);
        $this->render('editor_article_html.php');
    }

    public function SaveArticleJson() {
        $id= $this->request->getParameter("id", pInteger);
        // TODO Redirect if no ID
        $page = new ca_site_pages($id);
        $page->setMode(ACCESS_WRITE);
        $article = $page->get("content");
        $article["blocs"]=json_encode($_POST);
        $article["blocs"]=str_replace('"false"',"false",$article["blocs"]);
        $article["blocs"]=str_replace('"true"',"true",$article["blocs"]);
        $page->set("content", $article);
        $page->update();
        if($page->numErrors()) {
            print json_encode(["result"=>"ko", "errors"=>json_encode($page->getErrors())]);
        } else {
            print json_encode(["result"=>"ok", "id"=>$id]);
        }
    }

    public function Properties() {
        $is_redactor = false;
        foreach($this->getRequest()->getUser()->getUserGroups() as $group) {
            if($group["code"] == "redactor") $is_redactor=true;
        }
        $this->view->setVar("is_redactor", $is_redactor);

        $id= $this->request->getParameter("id", pInteger);
        // TODO Redirect if no ID
        $page = new ca_site_pages($id);
        //$page = new ca_site_pages(1);
        $this->view->setVar("page", $page);
        $article = $page->get("content");
        $lang = $page->get("keywords");
        $titre = $page->get("title");

        $this->view->setVar("titre", $titre);
        $this->view->setVar("lang", $lang);
        $this->view->setVar("access", $page->get("access"));
        $this->view->setVar("article", $article);

        $this->view->setVar("id", $id);
        $this->render('editor_properties_html.php');
    }

    public function SaveArticleProperties() {
        $id= $this->request->getParameter("id", pInteger);
        var_dump($_POST);
        // TODO Redirect if no ID or if no site page corresponding the ID
        $vt_page = new ca_site_pages($id);
        $vt_page->setMode(ACCESS_WRITE);
        //$vt_page->set(["template_id"=>1, "title"=>"article...", "description"=>"", "path"=>"/path".$this->getRandomWord(), "access"=>0 ]);
        $vt_page->set("keywords", $this->request->getParameter("keywords", pString));
        $vt_page->set("title", $this->request->getParameter("titre", pString));
        $content=[
            "title" => $this->request->getParameter("titredisplay", pString),
            "subtitle" => $this->request->getParameter("titredisplay", pString),
            "author"=> $this->request->getParameter("titredisplay", pString),
            "date"=> $this->request->getParameter("titredisplay", pString),
            "date_from"=>$this->request->getParameter("titredisplay", pString),
            "date_to"=>$this->request->getParameter("titredisplay", pString),
            "image"=>$this->request->getParameter("titredisplay", pString)
        ];
        // Note : there are two other templates var : blocks & bodytext, we don't feed them here.
        $vt_page->update();
        //$id = $vt_page->getPrimaryKey();
        //$vt_page->set("ca_site_pages.content", ["image"=>"/img_article_phoi.png"]);
        //$vt_page->update();
        //$article = $page->get("content");
        $this->redirect("/index.php/Articles/Editor/Properties/id/".$id);
    }

    public function Publish() {
        $is_redactor = false;
        foreach($this->getRequest()->getUser()->getUserGroups() as $group) {
            if($group["code"] == "redactor") $is_redactor=true;
        }
        $id= $this->request->getParameter("id", pInteger);
        // TODO Redirect if no ID
        $page = new ca_site_pages($id);
        $page->setMode(ACCESS_WRITE);
        $page->set("access", 1);
        $page->update();

        $this->redirect("/index.php/Articles/Show/Details/id/".$id);
    }

    public function Unpublish() {
        $is_redactor = false;
        foreach($this->getRequest()->getUser()->getUserGroups() as $group) {
            if($group["code"] == "redactor") $is_redactor=true;
        }
        $id= $this->request->getParameter("id", pInteger);
        // TODO Redirect if no ID
        $page = new ca_site_pages($id);
        $page->setMode(ACCESS_WRITE);
        $page->set("access", 0);
        $page->update();

        $this->redirect("/index.php/Articles/Show/Details/id/".$id);
    }

}
?>
