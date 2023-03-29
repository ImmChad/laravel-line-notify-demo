<?php

namespace App\Handler\Common;

use App\Models\Constrant\Roles;
use App\Models\Seeker;
use App\Models\User;
use App\Models\StaticPref;
use App\Repository\Seeker\SeekerExpectLocationRepository;
use App\Repository\Seeker\SeekerRepository;
use App\Repository\Static\AreaRepository;
use App\Repository\Static\PrefectureRepository;
use App\Repository\User\UserRepository;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation;
use Webpatser\Uuid\Uuid;

class AuthHandler
{
    public function __construct(private UserRepository $userRepository, private CryptHandler $cryptHandler)
    {
    }
    /**
     * @param Request $request
     *
     * @return bool|RedirectResponse
     */
    public function register(Request $request) : bool|RedirectResponse
    {
        $seekerRepository = new SeekerRepository();
        $seekerExpectLocationRepository = new SeekerExpectLocationRepository();
        $birthday = Str::replace('/', '', $request->get('birthday'));

        try {
            $id = (string) Uuid::generate(4);
            $phone = $this->cryptHandler->encryptString($request->get('phone'));
            $user = $this->userRepository->findOneByPhone($phone);
            $seekerRepository->create([
                'id' => $id,
                'user_id' => $user->id,
                'birthday' => $birthday,
                'nickname' => $request->get('nickname'),
            ]);

            if (null !== $request->get('area')) {
                foreach ($request->get('area') as $area) {
                    $seekerExpectLocationRepository->create([
                        'user_id' => $user->id,
                        'area_id' => $area,
                    ]);
                }
            }
            Session::flush();
            Auth::login($user, true);

            return true;
        } catch (Exception $ex) {
            Session::flash('error', $ex->getMessage());

            return Redirect::back()->send();
        }
    }

    /**
     * @param Request $request
     *
     * @return Validation\Validator
     */
    public function validateRegister(Request $request): Validation\Validator
    {
        return Validator::make($request->all(), [
            'nickname' => 'required',
            'birthday' => 'date|required',
            'area.*' => 'required|distinct',
            'pref.*' => 'required|distinct',
        ]);
    }

    /**
     * @return Collection
     */
    public function getAllPref(): Collection
    {
        $prefectureRepository = new PrefectureRepository();

        return $prefectureRepository->getAll();
    }

    /**
     * @param $prefId
     *
     * @return Collection
     */
    public function getAreasByPrefId($prefId): Collection
    {
        $areaRepository = new AreaRepository();

        return $areaRepository->find(['pref_cd' => $prefId]);
    }

    /**
     * @param $regionCd
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder[]|StaticPref[]
     */
    public function getPrefecturesByRegion($regionCd) : array|\Illuminate\Database\Eloquent\Collection
    {
        return StaticPref::where('region_cd', $regionCd)->get();
    }

    /**
     * @param $credentials
     *
     * @return RedirectResponse
     */
    public function attemptLogin($credentials) : RedirectResponse
    {
        $phone = $credentials->get('phone');
        $email = $credentials->get('email');
        $password = $credentials->get('password');

        if (null !== $phone) {
            $encryptedPhone = $this->cryptHandler->encryptString($phone);
            $user = User::where('phone_number_landline', $encryptedPhone)->with('seeker')->whereNull('deleted_at')->first();
        } else {
            $encryptedEmail = $this->cryptHandler->encryptString($email);
            $user = User::where('email', $encryptedEmail)->with('seeker')->whereNull('deleted_at')->first();
        }

        if(null !== $user && Hash::check($password, $user->password)) {
            if($user->seeker === null) {
                Session::put('phone', $user->phone_number_landline);

                return Redirect::route('register.get')->send();
            }
            Auth::login($user, true);

            return Redirect::to('/');
        }

        if (null !== $phone) {
            return Redirect::to('/login')->with([
                'phone' => $phone,
                'error' => 'Login failed! Wrong credentials',
            ])->send();
        }

        return Redirect::to('/login?by=email')->with([
            'email' => $email,
            'error' => 'Login failed! Wrong credentials',
        ])->send();
    }

    /**
     * @param $credentials
     *
     * @return bool
     */
    public function attemptLoginBar($credentials): bool
    {
        $users = $this->userRepository->getAll();
        $loginId = $credentials['login_id'];
        $role = $credentials['role'];

        foreach ($users as $user) {
            try {
                if ($loginId == $user->login_id && Hash::check(
                    $credentials['password'],
                    $user->password
                ) && $role == $user->role) {
                    Auth::login($user, true);
                    return true;
                }
            } catch (DecryptException $e) {
                continue;
            }
        }

        return false;
    }

    /**
     * @param Request $request
     *
     * @return Validation\Validator
     */
    public function validateRegisterStore(Request $request): Validation\Validator
    {
        return Validator::make($request->all(), [
            'store_name' => 'required',
            'post_code' => 'required',
            'business_type' => 'required',
            'type_of_permit' => 'required',
            'attachment_of_permit' => 'require|mimes:jpg,png',
            'plan_for_publication' => 'required',
            'mail_address' => 'required|email',
            'phone_num' => 'required|numeric',
            'admin_contact_phone' => 'required|numeric',
            'person_in_charge' => 'required',
            'is_agree' => 'required',
            'attraction_source' => 'required',
            'comment' => 'required',
        ]);
    }

    /**
     * @param $credentials
     *
     * @return bool
     */
    public function attemptLoginAdmin($credentials): bool
    {
        $users = $this->userRepository->getAll();
        $email = $credentials['email'];
        $role = $credentials['role'];

        foreach ($users as $user) {
            try {
                if ($email == $user->email && Hash::check(
                    $credentials['password'],
                    $user->password
                ) && $role == $user->role) {
                    Auth::login($user, true);
                    return true;
                }
            } catch (DecryptException $e) {
                continue;
            }
        }

        return false;
    }
}
