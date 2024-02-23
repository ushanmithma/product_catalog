<?php

/**
 * Add error to log
 *
 * @param  Exception  $e
 */
function addErrorToLog(\Exception $e)
{
    Log::error($e->getMessage()."\n".$e->getTraceAsString());
}
