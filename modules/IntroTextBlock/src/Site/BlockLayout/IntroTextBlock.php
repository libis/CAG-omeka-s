<?php
namespace IntroTextBlock\Site\BlockLayout;

use Omeka\Site\BlockLayout\AbstractBlockLayout;
use Omeka\Api\Representation\SiteRepresentation;
use Omeka\Api\Representation\SitePageRepresentation;
use Omeka\Api\Representation\SitePageBlockRepresentation;
use Omeka\Stdlib\HtmlPurifier;
use Omeka\Stdlib\ErrorStore;
use Zend\Form\Element\Textarea;
use Zend\View\Renderer\PhpRenderer;

/**
 * The block layout class encapsulates everything about your custom block.
 *
 * Everything the user sees about your block, both on the admin and public
 * sides, gets defined here.
 */
class IntroTextBlock extends AbstractBlockLayout
{
    /**
     * getLabel() is where you define the label users will see when selecting
     * your block.
     *
     * @return string
     */
    public function getLabel()
    {
        return 'CAG - Intro without image'; // @translate
    }

    /**
     * The form() method is where the form for your block is defined.
     *
     * You can use the following helpers here for some common pieces of
     * the block form interface:
     *
     * - $view->blockAttachmentsForm($block) (to select items and media)
     * - $view->blockThumbnailTypeSelect($block) (to select the "size" of images to show)
     * - $view->blockShowTitleSelect($block) (to select where displayed attachment titles should come from)
     *
     * You can use form elements more or less as usual here, but you'll
     * want to take care with the names of your form elements: the form
     * expects all your custom elements to have names starting with the
     * following prefix:
     *
     * `o:block[__blockIndex__][o:data]`
     *
     * Anything starting with that prefix will automatically be saved to
     * the block's `data` property.
     *
     * @return string
     */
    public function form(PhpRenderer $view, SiteRepresentation $site,
        SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null
    ) {
        //$data = $block ? $block->data() : [];
        return $view->partial('common/block-layout/intro-text-block-form', [
            'block' => $block,
        ]);
    }

    /**
     * render() is pretty much the opposite of form(): it's where you
     * define the output of the block for the public side.
     *
     * This is the heart of a block layout: everything you collect on
     * form will get used here for the display.
     *
     * You'll generally be working with $block here, the block's API
     * representation, which gives you access to all the saved data
     * about the block. In particular, you might use:
     *
     * `$block->attachments()` (returns all attached items/media from the form)
     * `$block->dataValue($key)` (get a saved custom data value)
     *
     * @return string
     */
    public function render(PhpRenderer $view, SitePageBlockRepresentation $block)
    {

      return $view->partial('common/block-layout/intro-text-block', [
        'block' => $block,
        'attachments' => $block->attachments()
      ]);

      /*return $view->partial('common/block-layout/tiles', [
          'block' => $block,
          'attachments' => $attachments,
          'alignmentClass' => $alignmentClass,
          'thumbnailType' => $thumbnailType,
          'link' => $linkType,
          'showTitleOption' => $showTitleOption,
      ]);*/
    }
}
