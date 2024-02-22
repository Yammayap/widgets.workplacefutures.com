<?php

namespace App\Http\Controllers;

use App\Models\User;
use Artesaos\SEOTools\Traits\SEOTools;
use Illuminate\Support\Facades\Auth;

abstract class WebController extends Controller
{
    use SEOTools;

    /**
     * @var string
     */
    protected string $metaTitleSuffix;

    /**
     * WebController constructor.
     */
    public function __construct()
    {
        $appName = (string) config('app.name');

        $this->metaTitleSuffix(config('seotools.meta.defaults.separator') . $appName);
        $this->metaTitle($appName, false);
        $this->metaRobotsAllow();

        $this->seo()->opengraph()->setSiteName($appName);
    }

    /**
     * @param string $description
     *
     * @return $this
     */
    protected function metaDescription(string $description): self
    {
        $this->seo()->setDescription($description);

        return $this;
    }

    /**
     * @param string $suffix
     *
     * @return $this
     */
    protected function metaTitleSuffix(string $suffix): self
    {
        $this->metaTitleSuffix = $suffix;

        return $this;
    }

    /**
     * @param string $title
     * @param bool $useSuffix
     *
     * @return $this
     */
    protected function metaTitle(string $title, bool $useSuffix = true): self
    {
        $setTitle = trim($title);

        if ($useSuffix) {
            $setTitle .= $this->metaTitleSuffix;
        }

        if (config('app.debug')) {
            $setTitle = '[' . strtoupper(strval(config('app.env'))) . '] ' . $setTitle;
        }

        $this->seo()->metatags()->setTitle($setTitle);

        return $this;
    }

    /**
     * @return $this
     */
    protected function metaRobotsAllow(): self
    {
        return $this->metaRobots('index, follow');
    }

    /**
     * @return $this
     */
    protected function metaRobotsDeny(): self
    {
        return $this->metaRobots('noindex, follow');
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    private function metaRobots(string $value): self
    {
        $this->seo()->metatags()->addMeta('robots', $value);

        return $this;
    }

    /**
     * @param string $url
     *
     * @return $this
     */
    protected function ogImage(string $url): self
    {
        $this->seo()->opengraph()->addImage($url);

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    protected function ogTitle(string $title): self
    {
        $this->seo()->opengraph()->setTitle($title);

        return $this;
    }

    /**
     * @return User
     */
    public function authUser(): User
    {
        // todo: discuss - would this be better in the Helpers class so we can use it anywhere not just controllers?
        // (it's here because this is where we normally put it)

        /**
         * @var User $user
         */
        $user = Auth::user();

        return $user;
    }
}
