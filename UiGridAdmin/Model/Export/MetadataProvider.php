<?php

namespace ScripCo\UiGridAdmin\Model\Export;

use Magento\Framework\Locale\ResolverInterface;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use Magento\Framework\View\Element\UiComponentInterface;
use Magento\Ui\Component\MassAction\Filter;

class MetadataProvider extends \Magento\Ui\Model\Export\MetadataProvider
{
    protected $_bookmarkManagement;


    public function __construct(
        Filter $filter,
        TimezoneInterface $localeDate,
        ResolverInterface $localeResolver,
        \Magento\Ui\Model\BookmarkManagement $bookmarkManagement,
        $dateFormat = 'M j, Y H:i:s A',
        array $data = []
    ) {
        $this->filter = $filter;
        $this->localeDate = $localeDate;
        $this->locale = $localeResolver->getLocale();
        $this->dateFormat = $dateFormat;
        $this->data = $data;
        parent::__construct($filter, $localeDate, $localeResolver, $dateFormat, $data);
        $this->_bookmarkManagement = $bookmarkManagement;
    }

    public function getActiveColumns($component)
    {
        $bookmark = $this->_bookmarkManagement->getByIdentifierNamespace('current', $component->getName());
        $config = $bookmark->getConfig();
        $columns = $config['current']['columns'];
        $_activeColumns = [];
        foreach ($columns as $column => $config) {
            if (true === $config['visible']) {
                $_activeColumns[] = $column;
            }
        }
        return $_activeColumns;
    }

    /**
     * Retrieve Headers row array for Export
     *
     * @param UiComponentInterface $component
     * @return string[]
     */
    public function getHeaders(UiComponentInterface $component): array
    {
        $row = [];
        $visibleRecords = $this->getActiveColumns($component);
        foreach ($this->getColumns($component) as $column) {
            if (in_array($column->getName(), $visibleRecords)) {
                $row[] = $column->getData('config/label');
            }
        }
        return $row;
    }

    /**
     * Returns DB fields list
     *
     * @param UiComponentInterface $component
     * @return array
     */
    public function getFields(UiComponentInterface $component): array
    {
        $row = [];
        $visibleRecords = $this->getActiveColumns($component);
        foreach ($this->getColumns($component) as $column) {
            if (in_array($column->getName(), $visibleRecords)) {
                $row[] = $column->getName();
            }
        }
        return $row;
    }
}
