<?php
namespace KodiCMS\CMS\Contracts;

interface ModelUpdater
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param integer $id
     * @param  array  $data
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator($id, array $data);


    /**
     * Create a new user instance after a valid registration.
     *
     * @param integer $id
     * @param  array  $data
     *
     * @return Model
     */
    public function update($id, array $data);

}