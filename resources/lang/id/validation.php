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

    'accepted' => 'Kolom :attribute harus di setujui.',
    'active_url' => 'Kolom :attribute bukan sebuah URL yang valid.',
    'after' => 'Kolom :attribute harus berupa tanggal setelah :date.',
    'after_or_equal' => 'Kolom :attribute harus berupa tanggal setelah atau sama dengan :date.',
    'alpha' => 'Kolom :attribute hanya boleh memuat huruf.',
    'alpha_dash' => 'Kolom :attribute hanya boleh memuat huruf, angka, strip dan garis bawah.',
    'alpha_num' => 'Kolom :attribute hanya boleh memuat huruf dan angka.',
    'array' => 'Kolom :attribute harus berupa sebuah array.',
    'before' => 'Kolom :attribute harus berupa tanggal sebelum :date.',
    'before_or_equal' => 'Kolom :attribute harus berupa tanggal sebelum atau sama dengan :date.',
    'between' => [
        'numeric' => 'Kolom :attribute harus di antara :min dan :max.',
        'file' => 'Kolom :attribute harus di antara :min dan :max KB.',
        'string' => 'Kolom :attribute harus di antara :min dan :max karakter.',
        'array' => 'Kolom :attribute harus ada di antara :min dan :max item.',
    ],
    'boolean' => 'Kolom :attribute harus bernilai benar atau salah.',
    'confirmed' => 'Konfirmasi kolom :attribute tidak cocok.',
    'date' => 'Kolom :attribute bukan sebuah tanggal yang valid.',
    'date_equals' => 'Kolom :attribute harus berupa tanggal equal to :date.',
    'date_format' => 'Kolom :attribute tidak cocok dengan format :format.',
    'different' => 'Kolom :attribute dan :other harus berbeda.',
    'digits' => 'Kolom :attribute harus :digits digits.',
    'digits_between' => 'Kolom :attribute harus di antara :min dan :max digits.',
    'dimensions' => 'Kolom :attribute has in image dimensions yang valid.',
    'distinct' => 'Kolom :attribute memiliki nilai duplikat.',
    'email' => 'Kolom :attribute harus berupa alamat email yang valid.',
    'ends_with' => 'Kolom :attribute harus di akhiri dengan: :values.',
    'exists' => 'The selected :attribute tidak valid.',
    'file' => 'Kolom :attribute harus berupa file.',
    'filled' => 'Kolom :attribute harus memiliki nilai.',
    'gt' => [
        'numeric' => 'Kolom :attribute harus lebih besar dari :value.',
        'file' => 'Kolom :attribute harus lebih besar dari :value KB.',
        'string' => 'Kolom :attribute harus lebih besar dari :value karakter.',
        'array' => 'Kolom :attribute harus lebih banyak dari :value item.',
    ],
    'gte' => [
        'numeric' => 'Kolom :attribute harus lebih besar dari/atau sama dengan :value.',
        'file' => 'Kolom :attribute harus lebih besar dari/atau sama dengan :value KB.',
        'string' => 'Kolom :attribute harus lebih besar dari/atau sama dengan :value karakter.',
        'array' => 'Kolom :attribute harus mempunyai :value item atau lebih.',
    ],
    'image' => 'Kolom :attribute harus berupa sebuah gambar.',
    'in' => 'Pilihan :attribute tidak valid.',
    'in_array' => 'Kolom :attribute tidak ditemukan di :other.',
    'integer' => 'Kolom :attribute harus berupa sebuah angka.',
    'ip' => 'Kolom :attribute harus berupa alamat IP yang valid.',
    'ipv4' => 'Kolom :attribute harus berupa alamat IPv4 yang valid.',
    'ipv6' => 'Kolom :attribute harus berupa alamat IPv6 yang valid.',
    'json' => 'Kolom :attribute harus berupa JSON string yang valid.',
    'lt' => [
        'numeric' => 'Kolom :attribute harus lebih kecil dari :value.',
        'file' => 'Kolom :attribute harus lebih kecil dari :value KB.',
        'string' => 'Kolom :attribute harus lebih kecil dari :value karakter.',
        'array' => 'Kolom :attribute must have lebih kecil :value item.',
    ],
    'lte' => [
        'numeric' => 'Kolom :attribute harus lebih kecil dari/atau sama dengan :value.',
        'file' => 'Kolom :attribute harus lebih kecil dari/atau sama dengan :value KB.',
        'string' => 'Kolom :attribute harus lebih kecil dari/atau sama dengan :value karakter.',
        'array' => 'Kolom :attribute must not have more than :value item.',
    ],
    'max' => [
        'numeric' => 'Kolom :attribute tidak boleh lebih besar dari :max.',
        'file' => 'Kolom :attribute tidak boleh lebih besar dari :max KB.',
        'string' => 'Kolom :attribute tidak boleh lebih besar dari :max karakter.',
        'array' => 'Kolom :attribute tidak boleh lebih besar dari :max item.',
    ],
    'mimes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
    'mimetypes' => 'Kolom :attribute harus berupa file dengan tipe: :values.',
    'min' => [
        'numeric' => 'Kolom :attribute harus lebih dari :min.',
        'file' => 'Kolom :attribute harus lebih dari :min KB.',
        'string' => 'Kolom :attribute harus lebih dari :min karakter.',
        'array' => 'Kolom :attribute harus berisi lebih dari :min item.',
    ],
    'not_in' => 'The selected :attribute tidak valid.',
    'not_regex' => 'Kolom :attribute tidak valid.',
    'numeric' => 'Kolom :attribute harus berupa number.',
    'password' => 'Password salah.',
    'present' => 'Kolom :attribute field harus present.',
    'regex' => 'Kolom :attribute tidak valid.',
    'required' => 'Kolom :attribute tidak boleh kosong.',
    'required_if' => 'Kolom :attribute tidak boleh kosong ketika :other adalah :value.',
    'required_unless' => 'Kolom :attribute tidak boleh kosong kecuali :other adalah :values.',
    'required_with' => 'Kolom :attribute tidak boleh kosong ketika terdapat :values.',
    'required_with_all' => 'Kolom :attribute tidak boleh kosong ketika terdapat :values.',
    'required_without' => 'Kolom :attribute tidak boleh kosong ketika tisak terdapat :values.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'Kolom :attribute dan :other harus sama.',
    'size' => [
        'numeric' => 'Kolom :attribute harus :size.',
        'file' => 'Kolom :attribute harus :size KB.',
        'string' => 'Kolom :attribute harus :size karakter.',
        'array' => 'Kolom :attribute harus memuat :size item.',
    ],
    'starts_with' => 'Kolom :attribute harus berawalan dengan: :values.',
    'string' => 'Kolom :attribute harus berupa string.',
    'timezone' => 'Kolom :attribute harus berupa zona yang valid.',
    'unique' => 'Kolom :attribute telah di gunakan.',
    'uploaded' => 'Kolom :attribute tidak ter-upload.',
    'url' => 'Format kolom :attribute tidak valid.',
    'uuid' => 'Kolom :attribute harus berupa UUID yang valid.',

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

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
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

    'attributes' => [],

];
