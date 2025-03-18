<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' =>                                "L'attribut doit être accepté.",
    'accepted_if' =>                                       "L'attribut doit être accepté quand: l'autre est: valeur.",
    'active_url' =>                                       "L'attribut: l'attribut n'est pas une URL valide.",
    'after' =>                                       "L'attribut doit être une date après: date.",
    'after_or_equal' =>                                       "L'attribut doit être une date après ou égale à: date.",
    'alpha' =>                                       "L'attribut ne doit contenir que des lettres.",
    'alpha_dash' =>                                       "L'attribut ne doit contenir que des lettres, des chiffres, des tirets et des soulignements.",
    'alpha_num' =>                                       "L'attribut ne doit contenir que des lettres et des chiffres.",
    'array' =>                                       "L'attribut doit être un tableau.",
    'before' =>                                       "L'attribut doit être une date avant: date.",
    'before_or_equal' =>                                       "L'attribut doit être une date avant ou égale à: date.",
    'between' =>                                       [
        'array' =>                                       "L'attribut doit avoir entre: min et: éléments max.",
        'file' =>                                       "L'attribut: l'attribut doit être entre: min et: max kilobytes.",
        'numeric' =>                                       "L'attribut doit être entre: min et: max.",
        'string' =>                                       "L'attribut doit être entre: min et: caractères max.",
    ],
    'boolean' =>                                       "Le champ: Attribut doit être vrai ou faux.",
    'confirmed' =>                                       "La confirmation: l'attribut ne correspond pas.",
    'current_password' =>                                       "Le mot de passe est incorrect.",
    'date' =>                                       "L'attribut: l'attribut n'est pas une date valide.",
    'date_equals' =>                                       "L'attribut doit être une date égale à: date.",
    'date_format' =>                                       "L'attribut ne correspond pas au format: format.",
    'declined' =>                                       "L'attribut doit être refusé.",
    'declined_if' =>                                       "L'attribut doit être refusé lorsque: l'autre est: valeur.",
    'different' =>                                       "L'attribut et: l'autre doit être différent.",
    'digits' =>                                       "L'attribut doit être: chiffres des chiffres.",
    'digits_between' =>                                       "L'attribut doit être entre: min et: chiffres max.",
    'dimensions' =>                                       "L'attribut a des dimensions d'image non valides.",
    'distinct' =>                                       "Le champ: Attribut a une valeur en double.",
    'doesnt_end_with' =>                                       "L'attribut peut ne pas se terminer par l'un des éléments suivants :: Valeurs.",
    'doesnt_start_with' =>                                       "L'attribut peut ne pas commencer par l'un des éléments suivants :: Valeurs.",
    'email' =>                                       "L'attribut doit être une adresse e-mail valide.",
    'ends_with' =>                                       "L'attribut doit se terminer par l'un des éléments suivants :: Valeurs.",
    'enum' =>                                       "L'attribut sélectionné est invalide.",
    'exists' =>                                       "L'attribut sélectionné est invalide.",
    'file' =>                                       "L'attribut doit être un fichier.",
    'filled' =>                                       "Le champ: Attribut doit avoir une valeur.",
    'gt' =>                                      [
        'array' =>                                       "L'attribut doit avoir plus que: les éléments de valeur.",
        'file' =>                                       "L'attribut doit être supérieur à: les kilo-kilobytes.",
        'numeric' =>                                       "L'attribut doit être supérieur à: valeur.",
        'string' =>                                       "L'attribut doit être supérieur à: les caractères de valeur.",
    ],
    'gte' =>                                       [
        'array' =>                                       "L'attribut doit avoir: des éléments de valeur ou plus.",
        'file' =>                                       "L'attribut doit être supérieur ou égal à: Valeur kilobytes.",
        'numeric' =>                                       "L'attribut doit être supérieur ou égal à: valeur.",
        'string' =>                                       "L'attribut doit être supérieur ou égal à: les caractères de valeur.",
    ],
    'image' =>                                       "L'attribut doit être une image.",
    'in' =>                                      "L'attribut sélectionné est invalide.",
    'in_array' =>                                       "Le champ: Attribut n'existe pas dans: Autre.",
    'integer' =>                                       "L'attribut doit être un entier.",
    'ip' =>                                      "L'attribut doit être une adresse IP valide.",
    'ipv4' =>                                       "L'attribut doit être une adresse IPv4 valide.",
    'ipv6' =>                                       "L'attribut doit être une adresse IPv6 valide.",
    'json' =>                                       "L'attribut doit être une chaîne JSON valide.",
    'lt' =>                                      [
        'array' =>                                       "L'attribut doit avoir moins de: éléments de valeur.",
        'file' =>                                       "L'attribut doit être inférieur à: les kilobytes de valeur.",
        'numeric' =>                                       "L'attribut doit être inférieur à: la valeur.",
        'string' =>                                       "L'attribut doit être inférieur à: les caractères de valeur.",
    ],
    'lte' =>                                       [
        'array' =>                                       "L'attribut ne doit pas avoir plus que: les éléments de valeur.",
        'file' =>                                       "L'attribut doit être inférieur ou égal à: Valeur kilobytes.",
        'numeric' =>                                       "L'attribut doit être inférieur ou égal à: valeur.",
        'string' =>                                       "L'attribut doit être inférieur ou égal à: les caractères de valeur.",
    ],
    'mac_address' =>                                       "L'attribut doit être une adresse MAC valide.",
    'max' =>                                       [
        'array' =>                                       "L'attribut ne doit pas avoir plus que: les éléments maximaux.",
        'file' =>                                       "L'attribut ne doit pas être supérieur à: Max Kilobytes.",
        'numeric' =>                                       "L'attribut ne doit pas être supérieur à: Max.",
        'string' =>                                       "L'attribut ne doit pas être plus grand que: les caractères max.",
    ],
    'max_digits' =>                                       "L'attribut ne doit pas avoir plus de: chiffres maximaux.",
    'mimes' =>                                       "L'attribut doit être un fichier de type :: valeurs.",
    'mimetypes' =>                                       "L'attribut doit être un fichier de type :: valeurs.",
    'min' =>                                       [
        'array' =>                                       "L'attribut doit avoir au moins: les éléments min.",
        'file' =>                                       "L'attribut doit être au moins: les kilobytes min.",
        'numeric' =>                                       "L'attribut doit être au moins: min.",
        'string' =>                                       "L'attribut doit être au moins: les caractères min.",
    ],
    'min_digits' =>                                       "L'attribut doit avoir au moins: les chiffres min.",
    'multiple_of' =>                                       "L'attribut doit être un multiple de: valeur.",
    'not_in' =>                                       "L'attribut sélectionné est invalide.",
    'not_regex' =>                                       "Le format: attribut n'est pas valide.",
    'numeric' =>                                       "L'attribut doit être un nombre.",
    'password' =>                                       [
        'letters' =>                                       "L'attribut doit contenir au moins une lettre.",
        'mixed' =>                                       "L'attribut doit contenir au moins une lettre majuscule et une lettre minuscule.",
        'numbers' =>                                       "L'attribut doit contenir au moins un nombre.",
        'symbols' =>                                       "L'attribut doit contenir au moins un symbole.",
        'uncompromised' =>                                       "L'attribut donné: est apparu dans une fuite de données. Veuillez choisir un autre: attribut.",
    ],
    'present' =>                                       "Le champ d'attribut doit être présent.",
    'prohibited' =>                                       "Le champ d'attribut est interdit.",
    'prohibited_if' =>                                       "Le champ d'attribut est interdit quand: l'autre est: valeur.",
    'prohibited_unless' =>                                       "The: AttributeE Field est interdit à moins que: l'autre est dans: VALEURS. ",
    'prohibits' =>                                       "Le champ d'attribut interdit: autres d'être présents.",
    'regex' =>                                       "Le format: attribut n'est pas valide.",
    'required' =>                                       "Le champ d'attribut est requis.",
    'required_array_keys' =>                                       "Le champ d'attribut doit contenir des entrées pour :: valeurs.",
    'required_if' =>                                       "Le champ d'attribut est requis lorsque: l'autre est: valeur.",
    'required_if_accepted' =>                                       "Le champ d'attribut est requis lorsque: l'autre est accepté.",
    'required_unless' =>                                       "Le champ d'attribut est requis à moins que: l'autre est dans: VALEURS.",
    'required_with' =>                                       "Le champ d'attribut est requis lorsque: des valeurs sont présentes.",
    'required_with_all' =>                                       "Le champ: Attribut est requis lorsque: des valeurs sont présentes.",
    'required_without' =>                                       "Le champ: Attribut est requis lorsque: les valeurs ne sont pas présentes.",
    'required_without_all' =>                                       "Le champ: Attribut est requis lorsque aucune des valeurs n'est présente.",
    'same' =>                                       "L'attribut: Attribut et: Autre doit correspondre.",
    'size' =>                                       [
        'array' =>                                       "L'attribut doit contenir: les éléments de taille.",
        'file' =>                                       "L'attribut doit être: taille des kilobytes.",
        'numeric' =>                                       "L'attribut doit être: taille.",
        'string' =>                                       "L'attribut doit être: des caractères de taille.",
    ],
    'starts_with' =>                                       "L'attribut doit commencer par l'un des éléments suivants :: Valeurs.",
    'string' =>                                       "L'attribut doit être une chaîne.",
    'timezone' =>                                       "L'attribut doit être un fuseau horaire valide.",
    'unique' =>                                       "L'attribut: l'attribut a déjà été pris.",
    'uploaded' =>                                       "L'attribut a échoué à télécharger.",
    'url' =>                                       "L'attribut doit être une URL valide.",
    'uuid' =>                                       "L'attribut doit être un uuid valide.",

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

     'custom' =>                                      [
        'attribute-name' =>                                      [
            'rule-name' =>                                      'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' =>                                      [],

];
