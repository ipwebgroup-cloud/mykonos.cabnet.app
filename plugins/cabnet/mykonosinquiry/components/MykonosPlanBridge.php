<?php namespace Cabnet\MykonosInquiry\Components;

/**
 * Backward-compatible component alias wrapper.
 *
 * The live theme/plugin bridge expects the component class
 * Cabnet\MykonosInquiry\Components\MykonosPlanBridge to exist.
 *
 * The plugin currently ships PlanBridge.php as the concrete component.
 * This wrapper restores the expected class name without changing the
 * working bridge logic or the public /plan flow.
 */
class MykonosPlanBridge extends PlanBridge
{
}
