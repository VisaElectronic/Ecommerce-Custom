<?php declare(strict_types=1);

namespace MageMastery\Popup\Block\Adminhtml\Popup\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Model\UrlInterface;
use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{

    /**
     * Undocumented function
     *
     * @param UrlInterface $url
     * @param RequestInterface $request
     */
    public function __construct(
        private readonly UrlInterface $url,
        private readonly RequestInterface $request
    ) {}

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getPopupId(): int
    {
        return (int) $this->request->getParam('popup_id', 0);
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = []): string
    {
        return $this->url->getUrl($route, $params);
    }
}
