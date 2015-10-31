<?php
namespace KodiCMS\CMS\Navigation;

class Section extends ItemDecorator implements \Countable, \Iterator
{

    /**
     * @var array
     */
    protected $pages = [];

    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @var integer
     */
    protected $currentKey = 0;


    /**
     * @param array $data
     *
     * @return static
     */
    public static function factory($data = [])
    {
        return new static($data);
    }


    /**
     * @return string
     */
    public function getId()
    {
        return $this->getAttribute('id');
    }


    /**
     * @return array
     */
    public function getPages()
    {
        return $this->pages;
    }


    /**
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }


    /**
     * @param array $pages
     *
     * @return $this
     */
    public function addPages(array $pages)
    {
        foreach ($pages as $page) {
            if (isset( $page['children'] )) {

                $section = Collection::getSection($page['name'], $this);

                if (isset( $page['icon'] )) {
                    $section->icon = $page['icon'];
                }

                if (count($page['children']) > 0) {
                    $section->addPages($page['children']);
                }

            } else {
                $page = new Page($page);
                $this->addPage($page);
            }
        }

        return $this;
    }


    /**
     * @param ItemDecorator $page
     * @param integer       $priority
     *
     * @return $this
     */
    public function addPage(ItemDecorator & $page, $priority = 1)
    {
        $priority = (int) $priority;

        $permissions = $page->getPermissions();
        if ( ! empty( $permissions ) and ! acl_check($permissions)) {
            return $this;
        }

        if (isset( $page->priority )) {
            $priority = (int) $page->priority;
        }

        if ($page instanceof Section) {

            $this->sections[] = $page;
            $page->setSection($this);

        } else {
            if (isset( $this->pages[$priority] )) {
                while (isset( $this->pages[$priority] )) {
                    $priority++;
                }
            }

            $this->pages[$priority] = $page;
        }

        $page->setSection($this);

        return $this->update()->sort();
    }


    /**
     * @param string $currentUri
     *
     * @return boolean
     */
    public function findActivePageByUri($currentUri)
    {
        $found        = false;
        $adminDirName = backend_url();

        foreach ($this->getPages() as $page) {

            $url = $page->getUrl();
            $len = strpos($url, $adminDirName);
            if ($len !== false) {
                $len += strlen($adminDirName);
            }

            $url = substr($url, $len);

            $len = strpos($currentUri, $adminDirName);
            if ($len !== false) {
                $len += strlen($adminDirName);
            }

            $uri = substr($currentUri, $len);
            $pos = strpos($uri, $url);

            if ( ! empty( $url ) AND $pos !== false and $pos < 5) {
                $page->setStatus(true);
                Collection::setCurrentPage($page);
                $found = true;
                break;
            }
        }

        if ($found === false) {
            foreach ($this->getSections() as $section) {
                $found = $section->findActivePageByUri($currentUri);
                if ($found !== false) {
                    return $found;
                }
            }
        }

        return $found;
    }


    /**
     * @param string $name
     *
     * @return Section
     */
    public function findSection($name)
    {
        foreach ($this->getSections() as $section) {
            if ($section->getKey() == $name) {
                return $section;
            }
        }

        foreach ($this->getSections() as $section) {
            $found = $section->findSection($name);
            if ( ! is_null($found)) {
                return $found;
            }
        }

        return null;
    }


    /**
     * @param string $uri
     *
     * @return null|Page
     */
    public function & findPageByUri($uri)
    {
        foreach ($this->getPages() as $page) {
            if ($page->getUrl() == $uri) {
                return $page;
            }
        }

        foreach ($this->getSections() as $section) {
            $found = $section->findPageByUri($uri);
            if ( ! is_null($found)) {
                return $found;
            }
        }

        return null;
    }


    /**
     * @return Section
     */
    public function update()
    {
        return $this;
    }


    /**
     * @return Section
     */
    public function sort()
    {
        uasort($this->sections, function ($a, $b) {
            if ($a->priority == $b->priority) {
                return 0;
            }

            return ( $a->priority < $b->priority ) ? -1 : 1;
        });

        ksort($this->pages);

        return $this;
    }


    /**
     * Implements [Countable::count], returns the total number of rows.
     *
     *     echo count($result);
     *
     * @return  integer
     */
    public function count()
    {
        return count($this->pages);
    }


    /**
     * Implements [Iterator::key], returns the current row number.
     *
     *     echo key($result);
     *
     * @return  integer
     */
    public function key()
    {
        return key($this->pages);
    }


    /**
     * Implements [Iterator::key], returns the current breadcrumb item.
     *
     *     echo key($result);
     *
     * @return  integer
     */
    public function current()
    {
        return current($this->pages);
    }


    /**
     * Implements [Iterator::next], moves to the next row.
     *
     *     next($result);
     *
     * @return  $this
     */
    public function next()
    {
        next($this->pages);
    }


    /**
     * Implements [Iterator::prev], moves to the previous row.
     *
     *     prev($result);
     *
     * @return  $this
     */
    public function prev()
    {
        --$this->currentKey;
    }


    /**
     * Implements [Iterator::rewind], sets the current row to zero.
     *
     *     rewind($result);
     *
     * @return  $this
     */
    public function rewind()
    {
        reset($this->pages);
    }


    /**
     * Implements [Iterator::valid], checks if the current row exists.
     *
     * [!!] This method is only used internally.
     *
     * @return  boolean
     */
    public function valid()
    {
        $key = key($this->pages);

        return ( $key !== null AND $key !== false );
    }
}