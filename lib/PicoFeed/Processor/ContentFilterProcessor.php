<?php

namespace PicoFeed\Processor;

use PicoFeed\Base;
use PicoFeed\Filter\Filter;
use PicoFeed\Logging\Logger;
use PicoFeed\Parser\Feed;
use PicoFeed\Parser\Item;

/**
 * Item Content Filter
 *
 * @package PicoFeed\Processor
 * @author  Frederic Guillot
 */
class ContentFilterProcessor extends Base implements ItemProcessorInterface
{
    /**
     * Execute Item Processor
     *
     * @access public
     * @param  Feed $feed
     * @param  Item $item
     * @return bool
     */
    public function execute(Feed $feed, Item $item)
    {
        if ($this->config->getContentFiltering(true)) {
            // Have the entry URL act as the base URL for making URLs absolute.
            $filter = Filter::html($item->getContent(), $item->getUrl() ?: $feed->getSiteUrl());
            $filter->setConfig($this->config);
            $item->setContent($filter->execute());
        } else {
            Logger::setMessage(get_called_class().': Content filtering disabled');
        }

        return false;
    }
}
