<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Customer;

class RetrieveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:retrieve_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command retrieves users from https://randomuser.me/api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = (new \App\Services\RandomUserService)->getUsers(['au']);
        $bar   = $this->output->createProgressBar(count($result));
        
        $bar->start();

        foreach ($result as $item) {
            try {
                $userData = [
                    'email'    => $item['email'],
                    'username' => $item['login']['username'],
                    'password' => $item['login']['password'],
                ];

                $customerData = [
                    'user_id'    => 1,
                    'title'      => $item['name']['title'],
                    'first_name' => $item['name']['first'],
                    'last_name'  => $item['name']['last'],
                    'gender'     => $item['gender'],
                    'street'     => implode(', ', $item['location']['street']),
                    'city'       => $item['location']['city'],
                    'state'      => $item['location']['state'],
                    'country'    => $item['location']['country'],
                    'postcode'   => $item['location']['postcode'],
                    'birth_date' => now()->parse($item['dob']['date'])->toDateTimeString(),
                    'phone'      => $item['phone'],
                    'photo'      => $item['picture']['large'],
                    'thumbnail'  => $item['picture']['thumbnail'],
                ];

                $user = User::whereEmail($userData['email'])->first();

                if ($user) {
                    $user->update($userData);

                    if ($user->customer) {
                        $user->customer->update($customerData);
                    } else {
                        $user->customer()->create($customerData);
                    }
                    
                    continue;
                }

                $user = User::firstOrcreate($userData);
                $user->customer()->create($customerData);

            } catch (\Exception $exception) {
                \Log::error($exception->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
