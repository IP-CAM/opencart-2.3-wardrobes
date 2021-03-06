<?php
class ControllerProductCategory extends Controller {
	public function index() {

        if (isset($this->request->get['page']) && $this->request->get['page'] == '{page}') {
            $this->load->language('error/not_found');

            $this->document->setTitle($this->language->get('heading_title'));

            $this->document->addStyle('catalog/view/javascript/not_found/not_found.css');

            if ($this->request->server['HTTPS']) {
                $server = $this->config->get('config_ssl');
            } else {
                $server = $this->config->get('config_url');
            }
            $data['base'] = $server;

            $data['heading_title'] = $this->language->get('heading_title');

            $data['text_error'] = $this->language->get('text_error');

            $data['button_continue'] = $this->language->get('button_continue');

            $data['continue'] = $this->url->link('common/home');

            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

            $data['footer'] = $this->load->controller('common/footer');
            $data['header'] = $this->load->controller('common/header');

            $this->response->setOutput($this->load->view('error/not_found', $data));

        } else {
            $this->load->language('product/category');

            $this->load->model('catalog/category');

            $this->load->model('catalog/product');

            $this->load->model('tool/image');

            if (isset($this->request->get['filter'])) {
                $filter = $this->request->get['filter'];
            } else {
                $filter = '';
            }

            if (isset($this->request->get['sort'])) {
                $sort = $this->request->get['sort'];
            } else {
                $sort = 'p.sort_order';
            }

            if (isset($this->request->get['order'])) {
                $order = $this->request->get['order'];
            } else {
                $order = 'ASC';
            }

            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }

            if (isset($this->request->get['limit'])) {
                $limit = (int)$this->request->get['limit'];
            } else {
                $limit = $this->config->get($this->config->get('config_theme') . '_product_limit');
            }

            $this->load->language('common/header');
            $data['breadcrumbs'] = array();

            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home')
            );
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_cupboard'),
                'href' => $this->url->link('generalcatalog/generalcatalog')
            );


            if (isset($this->request->get['path'])) {
                $url = '';

                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }

                $path = '';

                $parts = explode('_', (string)$this->request->get['path']);

                $category_id = (int)array_pop($parts);

                foreach ($parts as $path_id) {
                    if (!$path) {
                        $path = (int)$path_id;
                    } else {
                        $path .= '_' . (int)$path_id;
                    }

                    $category_info = $this->model_catalog_category->getCategory($path_id);
                    if ($category_info) {
                        $data['breadcrumbs'][] = array(
                            'text' => $category_info['name'],
                            'href' => $this->url->link('product/category', 'path=' . $path . $url)
                        );
                    }
                }
            } else {
                $category_id = 0;
            }

            $category_info = $this->model_catalog_category->getCategory($category_id);
            $data['category_id'] = $category_id;

            //for mobile version
            if (isset($this->request->server['HTTP_REFERER'])) {
                $referer_mobile = $this->request->server['HTTP_REFERER'];
            } else {
                $referer_mobile = $this->url->link('common/home');
            }
            $data['referer_mobile'] = $referer_mobile;

            if ($category_info) {
               // $can_url=$this->url->link("product/category","path=".$this->request->get['path'] . '?limit=100');
              //  $this->document->addLink($can_url,"canonical");

                $this->document->setTitle($category_info['meta_title']);
                $this->document->setDescription($category_info['meta_description']);
                $this->document->setKeywords($category_info['meta_keyword']);

                $this->document->addStyle('catalog/view/javascript/jquery/owl-carousel-2/owl.carousel.min.css');
                $this->document->addScript('catalog/view/javascript/jquery/owl-carousel-2/owl.carousel.min.js');



                $this->document->addStyle('catalog/view/javascript/jquery/modal-window/modal-window.css');
                $this->document->addScript('catalog/view/javascript/jquery/modal-window/modal-window.js');

                $this->document->addStyle('catalog/view/javascript/category/category.css');
                $this->document->addScript('catalog/view/javascript/category/category.js');


                $data['heading_title'] = $category_info['name'];

                $data['text_refine'] = $this->language->get('text_refine');
                $data['text_empty'] = $this->language->get('text_empty');
                $data['text_quantity'] = $this->language->get('text_quantity');
                $data['text_manufacturer'] = $this->language->get('text_manufacturer');
                $data['text_model'] = $this->language->get('text_model');
                $data['text_price'] = $this->language->get('text_price');
                $data['text_tax'] = $this->language->get('text_tax');
                $data['text_points'] = $this->language->get('text_points');
                $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
                $data['text_sort'] = $this->language->get('text_sort');
                $data['text_limit'] = $this->language->get('text_limit');

                $data['button_cart'] = $this->language->get('button_cart');
                $data['button_more_info_cart'] = $this->language->get('button_more_info_cart');
                $data['button_wishlist'] = $this->language->get('button_wishlist');
                $data['button_compare'] = $this->language->get('button_compare');
                $data['button_continue'] = $this->language->get('button_continue');
                $data['button_list'] = $this->language->get('button_list');
                $data['button_grid'] = $this->language->get('button_grid');

                // Set the last category breadcrumb
                if(count($data['breadcrumbs']) < 3) {
                    $data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'])
                    );
                }


                $data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
                $data['description_down'] = html_entity_decode($category_info['description_down'], ENT_QUOTES, 'UTF-8');
                $data['compare'] = $this->url->link('product/compare');

                $url = '';

                if (isset($this->request->get['filter'])) {
                    $url .= '&filter=' . $this->request->get['filter'];
                }

                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }

                $data['categories'] = array();

                $results = $this->model_catalog_category->getCategories($category_id);

                foreach ($results as $result) {
                    $filter_data = array(
                        'filter_category_id'  => $result['category_id'],
                        'filter_sub_category' => true
                    );

                    $data['categories'][] = array(
                        'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                        'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '_' . $result['category_id'] . $url)
                    );
                }

                $data['products'] = array();

                $filter_data = array(
                    'filter_category_id' => $category_id,
                    'filter_filter'      => $filter,
                    'sort'               => $sort,
                    'order'              => $order,
                    'start'              => ($page - 1) * $limit,
                    'limit'              => $limit
                );

                $product_total = $this->model_catalog_product->getTotalProducts($filter_data);

                $results = $this->model_catalog_product->getProducts($filter_data);
                $data['products'] = $this->getProducts($results);



                $products_json_id = array();
                foreach($results as $result) {
                    $products_json_id[] = $result['product_id'];
                }
                //$data['products_json_id'] = addslashes(json_encode($products_json_id));
                $data['products_json_id'] = htmlspecialchars(json_encode($products_json_id));


                $url = '';

                if (isset($this->request->get['filter'])) {
                    $url .= '&filter=' . $this->request->get['filter'];
                }

                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }

                $data['sorts'] = array();

                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_default'),
                    'value' => 'p.sort_order-ASC',
                    'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.sort_order&order=ASC' . $url)
                );

                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_name_asc'),
                    'value' => 'pd.name-ASC',
                    'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=ASC' . $url)
                );

                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_name_desc'),
                    'value' => 'pd.name-DESC',
                    'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=pd.name&order=DESC' . $url)
                );

                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_price_asc'),
                    'value' => 'p.price-ASC',
                    'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=ASC' . $url)
                );

                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_price_desc'),
                    'value' => 'p.price-DESC',
                    'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.price&order=DESC' . $url)
                );

                /*if ($this->config->get('config_review_status')) {
                    $data['sorts'][] = array(
                        'text'  => $this->language->get('text_rating_desc'),
                        'value' => 'rating-DESC',
                        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=DESC' . $url)
                    );

                    $data['sorts'][] = array(
                        'text'  => $this->language->get('text_rating_asc'),
                        'value' => 'rating-ASC',
                        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=rating&order=ASC' . $url)
                    );
                }*/

                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_model_asc'),
                    'value' => 'p.model-ASC',
                    'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=ASC' . $url)
                );

                $data['sorts'][] = array(
                    'text'  => $this->language->get('text_model_desc'),
                    'value' => 'p.model-DESC',
                    'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . '&sort=p.model&order=DESC' . $url)
                );

                $url = '';

                if (isset($this->request->get['filter'])) {
                    $url .= '&filter=' . $this->request->get['filter'];
                }

                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }

                $data['limits'] = array();

                $limits = array_unique(array($this->config->get($this->config->get('config_theme') . '_product_limit'), 25, 50, 75, 100));

                sort($limits);

                foreach($limits as $value) {
                    $data['limits'][] = array(
                        'text'  => $value,
                        'value' => $value,
                        'href'  => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&limit=' . $value)
                    );
                }

                $url = '';

                if (isset($this->request->get['filter'])) {
                    $url .= '&filter=' . $this->request->get['filter'];
                }

                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }

                $pagination = new Pagination();
                $pagination->total = $product_total;
                $pagination->page = $page;
                $pagination->limit = $limit;
                $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');

                $data['pagination'] = $pagination->render();

                // http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
                $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'canonical');
               /* if ($page == 1) {
                } elseif ($page == 2) {
                    $data['links'] = $this->document->getLinks();
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'], true), 'prev');
                } else {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page - 1), true), 'prev');
                }


                if ($limit && ceil($product_total / $limit) > $page) {
                    $this->document->addLink($this->url->link('product/category', 'path=' . $category_info['category_id'] . '&page='. ($page + 1), true), 'next');
                } */

                $data['links'] = $this->document->getLinks();

                $data['sort'] = $sort;
                $data['order'] = $order;
                $data['limit'] = $limit;

                $data['continue'] = $this->url->link('common/home');

                $data['column_left'] = $this->load->controller('common/column_left');
                $data['column_right'] = $this->load->controller('common/column_right');
                $data['content_top'] = $this->load->controller('common/content_top');
                $data['content_bottom'] = $this->load->controller('common/content_bottom');
                $data['footer'] = $this->load->controller('common/footer');
                $data['header'] = $this->load->controller('common/header');

                $categories = $this->model_catalog_category->getCategoriesAll();
                $children_data = array();
                foreach ($categories as $category) {
                    $children_data[$category['category_id']]['href'] = $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $category['category_id']);
                }

                if ($this->request->server['HTTPS']) {
                    $server = $this->config->get('config_ssl');
                } else {
                    $server = $this->config->get('config_url');
                }
                $data['category_image'] = $server . 'image/' .  $category['image'];
                $data['categories'] = $children_data;

                $this->response->setOutput($this->load->view('product/category', $data));
            } else {
                $url = '';

                if (isset($this->request->get['path'])) {
                    $url .= '&path=' . $this->request->get['path'];
                }

                if (isset($this->request->get['filter'])) {
                    $url .= '&filter=' . $this->request->get['filter'];
                }

                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }

                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }

                if (isset($this->request->get['page'])) {
                    $url .= '&page=' . $this->request->get['page'];
                }

                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }

                $data['breadcrumbs'][] = array(
                    'text' => $this->language->get('text_error'),
                    'href' => $this->url->link('product/category', $url)
                );




                $this->document->setTitle($this->language->get('text_error'));

                $data['heading_title'] = $this->language->get('text_error');

                $data['text_error'] = $this->language->get('text_error');

                $data['button_continue'] = $this->language->get('button_continue');

                $data['continue'] = $this->url->link('common/home');

                $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

                $data['column_left'] = $this->load->controller('common/column_left');
                $data['column_right'] = $this->load->controller('common/column_right');
                $data['content_top'] = $this->load->controller('common/content_top');
                $data['content_bottom'] = $this->load->controller('common/content_bottom');
                $data['footer'] = $this->load->controller('common/footer');
                $data['header'] = $this->load->controller('common/header');

                $this->response->setOutput($this->load->view('error/not_found', $data));
            }
        }


	}


    private function getProducts($results)
    {
        $data = array();
        foreach ($results as $result) {
            $data_pr = array(
                'product_id'       => $result['product_id'],
                'image'       => $result['image'],
                'name'        => $result['name'],
                'price'       => $result['price'],
                'special'     => $result['special'],
                'button_text'     => 'Подробнее'
            );
            $data[] = $this->load->controller('product/product_item', $data_pr);
        }
        return $data;
    }


    public function productFilterPrice()
    {
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('tool/image');

        $min = $this->request->post['min'];
        $max = $this->request->post['max'];
        $this->load->model('catalog/product');

        $category_id = $this->request->post['category_id'];

        $results = $this->model_catalog_category->getCategories($category_id);

        foreach ($results as $result) {
            $filter_data = array(
                'filter_category_id'  => $result['category_id'],
                'filter_sub_category' => true
            );

            $data['categories'][] = array(
                'name' => $result['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                'href' => $this->url->link('product/category', 'path=' . $result['category_id'] . '_' . $result['category_id'])
            );
        }

        $data['products'] = array();

        $filter = '';
        $sort = 'p.sort_order';
        $order = 'ASC';
        $page = 1;
        $limit = (int)100;

        $filter_data = array(
            'filter_category_id' => $category_id,
            'filter_filter'      => $filter,
            'sort'               => $sort,
            'order'              => $order,
            'start'              => ($page - 1) * $limit,
            'limit'              => $limit
        );


        $results = $this->model_catalog_product->getProducts($filter_data);

        foreach ($results as $result) {
            if($result['price'] < $min || $result['price'] >$max)
            {
                continue;
            }
            $data_pr = array(
                'product_id'       => $result['product_id'],
                'image'       => $result['image'],
                'name'        => $result['name'],
                'price'       => $result['price'],
                'special'     => $result['special'],
                'button_text'     => 'Подробнее'
            );
            $data['products'][] = $this->load->controller('product/product_item', $data_pr);
        }

        $product_html = "";
        foreach($data['products'] as $product) {
            $product_html .= $product;
        }
        $this->response->addHeader('Content-Type: application/json');
        $this->response->setOutput($product_html);
    }

}

