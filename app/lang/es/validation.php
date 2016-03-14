<?php

return array(

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"         => "Debe ser aceptado.",
    "active_url"       => "URL no válida.",
    "after"            => "Debe ser una fecha posterior a :date.",
    "alpha"            => "Solo debe contener letras.",
    "alpha_dash"       => "Solo debe contener letras, números y guiones.",
    "alpha_num"        => "Solo debe contener letras y números.",
    "array"            => "Debe ser un conjunto.",
    "before"           => "Debe ser una fecha anterior a :date.",
    "between"          => array(
        "numeric" => "Tiene que estar entre :min - :max.",
        "file"    => "Debe pesar entre :min - :max kilobytes.",
        "string"  => "Tiene que tener entre :min - :max caracteres.",
        "array"   => "Tiene que tener entre :min - :max ítems.",
    ),
    "confirmed"        => "La confirmación no coincide.",
    "date"             => "No es una fecha válida.",
    "date_format"      => "No corresponde al formato :format.",
    "different"        => ":attribute y :other deben ser diferentes.",
    "digits"           => "Debe tener :digits dígitos.",
    "digits_between"   => "Debe tener entre :min y :max dígitos.",
    "email"            => "No es un correo válido",
    "exists"           => "Entrada inválida.",
    "image"            => "Debe ser una imagen.",
    "in"               => "Campo inválido.",
    "integer"          => "Debe ser un número entero.",
    "ip"               => "Debe ser una dirección IP válida.",
    "max"              => array(
        "numeric" => "No debe ser mayor a :max.",
        "file"    => "No debe ser mayor que :max kilobytes.",
        "string"  => "No debe ser mayor que :max caracteres.",
        "array"   => "No debe tener más de :max elementos.",
    ),
    "mimes"            => "Debe ser un archivo con formato: :values.",
    "min"              => array(
        "numeric" => "El tamaño debe ser de al menos :min.",
        "file"    => "El tamaño debe ser de al menos :min kilobytes.",
        "string"  => "Debe contener al menos :min caracteres.",
        "array"   => "Debe tener al menos :min elementos.",
    ),
    "not_in"           => "Es inválido.",
    "numeric"          => "Debe ser numérico.",
    "regex"            => "El formato es inválido.",
    "required"         => "Campo obligatorio.",
    "required_if"      => "Campo obligatorio cuando :other es :value.",
    "required_with"    => "Campo obligatorio cuando :values está presente.",
    "required_with_all" => "Campo obligatorio cuando :values está presente.",
    "required_without" => "Campo obligatorio cuando :values no está presente.",
    "required_without_all" => "Campo obligatorio cuando ninguno de :values estén presentes.",
    "same"             => ":attribute y :other deben coincidir.",
    "size"             => array(
        "numeric" => "El tamaño debe ser :size.",
        "file"    => "El tamaño debe ser :size kilobytes.",
        "string"  => "Debe contener :size caracteres.",
        "array"   => "Debe contener :size elementos.",
    ),
    "unique"           => "Ya ha sido registrado.",
    "url"              => "Campo inválido.",
	"has"         => "Debe contener letras y números.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => array(
        'attribute-name' => array(
            'rule-name' => 'custom-message',
        ),
    ),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => array(
    ),

);
