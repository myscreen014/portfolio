<?php

/* log shortcut */
function varlog($var) {
	error_log(print_r($var, true));
}
