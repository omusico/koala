<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Image;
class Mode{
    /**
     * 只限定宽度
     * 宽度一定,高度自适应,等比缩放
     */
    const WIDTH=1;
    /**
     * 只限定最大宽度
     * 宽度小于最大宽度时不变,大于则缩放到允许的最大宽度,高度自适应,等比缩放
     */
    const MAXWIDTH=2;
    /**
     * 只限定最小宽度
     * 宽度小于最小宽度时缩放到允许的最小宽度,大于则不变,高度自适应,等比缩放
     */
    const MINWIDTH=4;
    /**
     * 只限定高度
     * 高度一定,高度自适应,等比缩放
     */
    const HEIGHT=8;
    /**
     * 只限定最大高度
     * 高度小于最大高度时不变,大于则缩放到允许的最大高度,宽度自适应,等比缩放
     */
    const MAXHEIGHT=16;
    /**
     * 只限定最小高度
     * 高度小于最小高度时缩放到允许的最小高度,大于则不变,宽度自适应,等比缩放
     */
    const MINHEIGHT=32;
    /**
     * all
     */
    const ALL = -1;
}