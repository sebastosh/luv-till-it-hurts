<?php

class B2S_Post_Filter {

    public $type;
    protected $postFilter = '';
    protected $searchAuthorId;
    protected $searchPostStatus;
    protected $searchPostShareStatus;
    protected $searchPostTitle;
    protected $searchPostCat;
    protected $searchPostType;
    protected $searchPublishDate;
    protected $searchSchedDate;
    protected $postAuthor;

    function __construct($type, $title = "", $authorId = 0, $postStatus = "", $schedDate = "", $postCat = "", $postType = "", $postShareStatus="") {  //type=all,publish,sched
        $this->type = $type;
        $this->searchPostTitle = $title;
        $this->searchAuthorId = (int)$authorId;
        $this->searchPostStatus = $postStatus;
        $this->searchPostShareStatus = $postShareStatus;
        $this->searchSchedDate = $schedDate;
        $this->searchPostCat = $postCat;
        $this->searchPostType = $postType;
    }

    public function getAutorData() {
        global $wpdb;
        $sqlAuthors = "SELECT `ID`,`display_name` FROM `$wpdb->users`";
        $this->postAuthor = $wpdb->get_results($sqlAuthors);
    }

    private function getAutorHtml() {
        $autor = '<div class="form-group"><select id="b2sSortPostAuthor" name="b2sSortPostAuthor" class="form-control b2s-select"><option value="">' . esc_html__('all authors', 'blog2social') . '</option>';
        foreach ($this->postAuthor as $var) {
            $selected = ($var->ID == (int) $this->searchAuthorId) ? 'selected' : '';
            $autorName = $var->display_name;
            //Bug: Converting json + PHP Extension
            if (function_exists('mb_strlen') && function_exists('mb_substr')) {
                $autorName = mb_strlen($var->display_name, 'UTF-8') > 27 ? mb_substr($var->display_name, 0, 27, 'UTF-8') . '...' : $autorName;
            }
            $autor .= '<option ' . $selected . ' value="' . esc_attr($var->ID) . '">' . esc_html($autorName) . '</option>';
        }
        $autor .= '</select></div>';
        return $autor;
    }

    private function getPostStatusHtml() {
        $typeData = array(array('key' => 'publish', 'value' => esc_html__('published', 'blog2social')), array('key' => 'future', 'value' => esc_html__('scheduled', 'blog2social')), array('key' => 'pending', 'value' => esc_html__('draft', 'blog2social')));
        $type = '<div class="form-group"><select id="b2sSortPostStatus" name="b2sSortPostStatus" class="form-control b2s-select"><option value="">' . esc_html__('all posts', 'blog2social') . '</option>';
        foreach ($typeData as $var) {
            $var = (object) $var;
            $selected = (!empty($this->searchPostStatus) && $var->key == $this->searchPostStatus) ? 'selected' : '';
            $type .= '<option ' . $selected . ' value="' . esc_attr($var->key) . '">' . esc_html($var->value) . '</option>';
        }
        $type .= '</select></div>';
        return $type;
    }

        private function getPostShareStatusHtml() {
        $typeData = array(array('key' => 'never', 'value' => __('not yet shared', 'blog2social')), array('key' => 'shared', 'value' => __('already shared', 'blog2social')), array('key' => 'scheduled', 'value' => __('currently scheduled', 'blog2social')));
        $type = '<div class="form-group"><select id="b2sSortPostShareStatus" name="b2sSortPostShareStatus" class="form-control b2s-select"><option value="">' . esc_html__('all statuses', 'blog2social') . '</option>';
        foreach ($typeData as $var) {
            $var = (object) $var;
            $selected = (!empty($this->searchPostShareStatus) && $var->key == $this->searchPostShareStatus) ? 'selected' : '';
            $type .= '<option ' . $selected . ' value="' . esc_attr($var->key) . '">' . esc_html($var->value) . '</option>';
        }
        $type .= '</select></div>';
        return $type;
    }
    
    private function getPublishDateHtml() {
        $typeData = array(array('key' => 'desc', 'value' => __('newest first', 'blog2social')), array('key' => 'asc', 'value' => __('oldest first', 'blog2social')));
        $type = '<div class="form-group"><select id="b2sSortPostPublishDate" name="b2sSortPostPublishDate" class="form-control b2s-select">';
        foreach ($typeData as $var) {
            $var = (object) $var;
            $selected = (!empty($this->searchPublishDate) && $var->key == $this->searchPublishDate) ? 'selected' : '';
            $type .= '<option ' . $selected . ' value="' . esc_attr($var->key) . '">' . esc_html($var->value) . '</option>';
        }
        $type .= '</select></div>';
        return $type;
    }

    private function getSchedDateHtml() {
        $typeData = array(array('key' => 'desc', 'value' => __('newest first', 'blog2social')), array('key' => 'asc', 'value' => __('oldest first', 'blog2social')));
        $type = '<div class="form-group"><select id="b2sSortPostSchedDate" name="b2sSortPostSchedDate" class="form-control b2s-select">';
        foreach ($typeData as $var) {
            $var = (object) $var;
            $selected = (!empty($this->searchSchedDate) && $var->key == $this->searchSchedDate) ? 'selected' : '';
            $type .= '<option ' . $selected . ' value="' . esc_attr($var->key) . '">' . esc_html($var->value) . '</option>';
        }
        $type .= '</select></div>';
        return $type;
    }

    private function getPostCatHtml() {
        $taxonomies = get_taxonomies(array('public' => true), "object", "and");
        $type = '<div class="form-group"><select id="b2sSortPostCat" name="b2sSortPostCat" class="form-control b2s-select"><option value="">' . esc_html__('all categories & tags', 'blog2social') . '</option>';
        foreach ($taxonomies as $tax => $taxValue) {
            $cat = get_categories(array('taxonomy' => $taxValue->name, 'number' => 100)); //since 3.7.0 => all too much load
            if (!empty($cat)) {
                $type.='<optgroup label="' . esc_attr($taxValue->labels->name) . '">';
                foreach ($cat as $key => $categorie) {
                    $selected = (!empty($this->searchPostCat) && $categorie->term_id == $this->searchPostCat) ? 'selected' : '';
                    $catName = $categorie->name;
                    //Bug: Converting json + PHP Extension
                    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
                        $catName = mb_strlen($categorie->name, 'UTF-8') > 27 ? mb_substr($categorie->name, 0, 27, 'UTF-8') . '...' : $catName;
                    }
                    $type .= '<option ' . $selected . ' value="' . esc_attr($categorie->term_id) . '">' . esc_html($catName) . '</option>';
                }
                $type .='</optgroup>';
            }
        }
        $type .= '</select></div>';
        return $type;
    }

    private function getPostTypeHtml() {
        $type = '<div class="form-group"><select id="b2sSortPostType" name="b2sSortPostType" class="form-control b2s-select"><option value="">' . esc_html__('all post types', 'blog2social') . '</option>';
        $post_types = get_post_types(array('public' => true));
        if (is_array($post_types) && !empty($post_types)) {
            //V5.0.0 Add Content Curation manuelly because is not public
            if ($this->type != 'all') {
                $post_types['Content Curation'] = 'b2s_ex_post';
            }
            foreach ($post_types as $k => $v) {
                if ($v != 'attachment' && $v != 'nav_menu_item' && $v != 'revision') {
                    $selected = (!empty($this->searchPostType) && $v == $this->searchPostType) ? 'selected' : '';
                    //Bug: Converting json + PHP Extension
                    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
                        $v = mb_strlen($v, 'UTF-8') > 27 ? mb_substr($v, 0, 27, 'UTF-8') . '...' : $v;
                    }
                    $type .= '<option ' . $selected . ' value="' . esc_attr($v) . '">' . esc_html(ucfirst($k)) . '</option>';
                }
            }
        }
        $type .= '</select></div>';
        return $type;
    }

    public function getItemHtml() {
        $this->getAutorData();
        $this->postFilter .= '<div class="form-group">
                                    <input id="b2sSortPostTitle" name="b2sSortPostTitle" maxlength="30" class="form-control b2s-input input-sm" value="' . esc_attr((empty($this->searchPostTitle) ? '' : $this->searchPostTitle)) . '" placeholder="' . esc_attr((empty($this->searchPostTitle) ? __('Search Title', 'blog2social') : '')) . '" type="text">
                             </div>';
        if (B2S_PLUGIN_ADMIN && $this->type != 'draft-post') {
            $this->postFilter .= $this->getAutorHtml();
        }
        if($this->type != 'draft') {
            $this->postFilter .= $this->getPostCatHtml();
            $this->postFilter .= $this->getPostTypeHtml();

            if ($this->type == 'all' || $this->type == 'draft-post') {
                $this->postFilter .= $this->getPostStatusHtml();
                $this->postFilter .= $this->getPostShareStatusHtml();
            }
            if ($this->type == 'publish' || $this->type == 'notice') {
                $this->postFilter .= $this->getPublishDateHtml();
            }
            if ($this->type == 'sched') {
                $this->postFilter .= $this->getSchedDateHtml();
            }
        }

        $this->postFilter .= '<div class="form-group">';

        $this->postFilter .='<a href="#" id="b2s-sort-submit-btn" class="btn btn-primary margin-top-8 btn-sm">' . esc_html__('sort', 'blog2social') . '</a>
                                    <a id="b2s-sort-reset-btn" class="btn btn-primary margin-top-8 btn-sm" href="#">' . esc_html__('reset', 'blog2social') . '</a>
                             </div>';

        if ($this->type == 'sched') {
            $this->postFilter .='<div id="b2s-sched-calendar-area"><br><div id="b2s-sched-datepicker-area"></div><br>';
            $this->postFilter .='<div class="pull-right"><small><span class="b2s-calendar-legend-active glyphicon glyphicon-stop"></span> ' . esc_html__('selected date', 'blog2social') . ' <span class="b2s-calendar-legend-event glyphicon glyphicon-stop"></span> ' . esc_html__('scheduled post(s)', 'blog2social') . '</small></div></div>';
        }

        return $this->postFilter;
    }

}
