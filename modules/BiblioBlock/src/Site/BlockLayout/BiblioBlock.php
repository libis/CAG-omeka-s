<?php
namespace BiblioBlock\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\View\Renderer\PhpRenderer;

class BiblioBlock extends AbstractBlockLayout
{
    public function getLabel()
    {
        return 'CAG - Bibliografie'; // @translate
    }

    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        
    }

    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {
        parse_str("property[0][joiner]=and&property[0][property]=&property[0][type]=eq&property[0][text]=&resource_class_id[]=&resource_template_id[]=6&item_set_id[]=&site_id=&submit=Zoeken", $query);
        $originalQuery = $query;

        $site = $block->page()->site();
        if ($view->siteSetting('browse_attached_items', false)) {
            $query['site_attachments_only'] = true;
        }

        $query['site_id'] = $site->id();
        $query['limit'] = $block->dataValue('limit', 9999);

        if (!isset($query['sort_by'])) {
            $query['sort_by'] = 'created';
        }
        if (!isset($query['sort_order'])) {
            $query['sort_order'] = 'desc';
        }

        $response = $view->api()->search('items', $query);
        $resources = $response->getContent();

        $resourceTypes = [
            'items' => 'item',
            'item_sets' => 'item-set',
            'media' => 'media',
        ];

        return $view->partial('common/block-layout/biblio-block', [
            'block' => $block,
            'resources' => $resources,
            'query' => $originalQuery,
        ]);
    }
}
