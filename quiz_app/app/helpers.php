<?php

function returnResponse($message, $status, $data = [])
{
    $returnJSON = array(
        "message" => $message
    );

    if (sizeof($data) != 0) $returnJSON['data'] = $data;

    return response()->json($returnJSON, $status);
}
