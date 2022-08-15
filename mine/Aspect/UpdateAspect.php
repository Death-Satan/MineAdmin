<?php
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */

declare(strict_types=1);
namespace Mine\Aspect;

use Hyperf\Di\Annotation\Aspect;
use Hyperf\Di\Aop\AbstractAspect;
use Hyperf\Di\Aop\ProceedingJoinPoint;
use Hyperf\Di\Exception\Exception;
use Mine\Helper\LoginUser;
use Mine\MineModel;

/**
 * Class UpdateAspect
 * @package Mine\Aspect
 */
#[Aspect]
class UpdateAspect extends AbstractAspect
{
    public $classes = [
        'Mine\MineModel::update'
    ];

    /**
     * @param ProceedingJoinPoint $proceedingJoinPoint
     * @return mixed
     * @throws Exception
     */
    public function process(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $instance = $proceedingJoinPoint->getInstance();
        // 更新更改人
        if ($instance instanceof MineModel &&
            in_array('updated_by', $instance->getFillable()) &&
            config('mineadmin.data_scope_enabled')
        ) {
            $instance->updated_by = user()->getId();
        }
        return $proceedingJoinPoint->process();
    }
}