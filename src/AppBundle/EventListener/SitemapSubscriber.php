<?php
/**
 * Created by Drupai.
 * User: 烽行天下
 * Date: 2018\4\11 0011
 * Time: 14:28
 */

namespace AppBundle\EventListener;

use AppBundle\Entity\Article;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Service\UrlContainerInterface;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;

class SitemapSubscriber implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var ManagerRegistry
     */
    private $doctrine;

    /**
     * @param UrlGeneratorInterface $urlGenerator
     * @param ManagerRegistry       $doctrine
     */
    public function __construct(UrlGeneratorInterface $urlGenerator, ManagerRegistry $doctrine)
    {
        $this->urlGenerator = $urlGenerator;
        $this->doctrine = $doctrine;
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SitemapPopulateEvent::ON_SITEMAP_POPULATE => 'populate',
        ];
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populate(SitemapPopulateEvent $event)
    {
        $this->registerArticleUrls($event->getUrlContainer());
    }

    /**
     * @param UrlContainerInterface $urls
     */
    public function registerArticleUrls(UrlContainerInterface $urls)
    {
        $posts = $this->doctrine->getRepository(Article::class)->findAll();

        foreach ($posts as $post) {
            $urls->addUrl(
                new UrlConcrete(
                    $this->urlGenerator->generate(
                        'show',
                        ['slug' => $post->getSlug()],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ),
                'default'
            );
        }
    }
}