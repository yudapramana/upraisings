<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AngkotTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['route_number' => '54', 'route_name' => 'Permindo - UNAND Limau Manis', 'color' => 'grey'],
            ['route_number' => '201', 'route_name' => 'M. Yamin - Siteba', 'color' => 'blue'],
            ['route_number' => '202', 'route_name' => 'M. Yamin - Balai Baru', 'color' => 'blue'],
            ['route_number' => '203', 'route_name' => 'M. Yamin - Pasar Raya', 'color' => 'blue'],
            ['route_number' => '204', 'route_name' => 'M. Yamin - Belimbing', 'color' => 'blue'],
            ['route_number' => '207', 'route_name' => 'M. Yamin - Kota Aia Pacah', 'color' => 'blue'],
            ['route_number' => '301', 'route_name' => 'Pangkalan Angkot - Indarung', 'color' => 'red'],
            ['route_number' => '303', 'route_name' => 'Pangkalan Angkot - Karang Putih', 'color' => 'red'],
            ['route_number' => '304', 'route_name' => 'Pangkalan Angkot - Ngalau', 'color' => 'red'],
            ['route_number' => '307', 'route_name' => 'Pangkalan Angkot - Ulu Gadut', 'color' => 'red'],
            ['route_number' => '401', 'route_name' => 'Pangkalan Angkot - Jondul Mata Air', 'color' => 'blue'],
            ['route_number' => '402', 'route_name' => 'Pangkalan Angkot - Air Manis', 'color' => 'blue'],
            ['route_number' => '403', 'route_name' => 'Pangkalan Angkot - Banuaran', 'color' => 'darkblue'],
            ['route_number' => '404', 'route_name' => 'Pangkalan Angkot - Seb Palinggam', 'color' => 'darkblue'],
            ['route_number' => '405', 'route_name' => 'Pangkalan Angkot - Cendana Mata Air', 'color' => 'darkblue'],
            ['route_number' => '407A', 'route_name' => 'M. Yamin - Penggambiran', 'color' => 'blue'],
            ['route_number' => '409', 'route_name' => 'Permindo - Simpang Koto Tingga', 'color' => 'green'],
            ['route_number' => '410', 'route_name' => 'Permindo - Durian Tarung', 'color' => 'red'],
            ['route_number' => '410A', 'route_name' => 'Permindo - Taruko Bypass', 'color' => 'purple'],
            ['route_number' => '411', 'route_name' => 'Permindo - Pasar Baru Pauh V', 'color' => 'red'],
            ['route_number' => '412', 'route_name' => 'Permindo - Pasar Baru Pauh', 'color' => 'red'],
            ['route_number' => '416', 'route_name' => 'M. Yamin - Pasir Putih', 'color' => 'blue'],
            ['route_number' => '417', 'route_name' => 'M. Yamin - Cimpago Putih', 'color' => 'blue'],
            ['route_number' => '419', 'route_name' => 'M. Yamin - Batas Kota', 'color' => 'blue'],
            ['route_number' => '420', 'route_name' => 'M. Yamin - Asrama Haji', 'color' => 'blue'],
            ['route_number' => '421', 'route_name' => 'M. Yamin - Parupuk Tabing', 'color' => 'blue'],
            ['route_number' => '422', 'route_name' => 'M. Yamin - Cendrawasih', 'color' => 'blue'],
            ['route_number' => '424', 'route_name' => 'M. Yamin - Wisma Warta', 'color' => 'blue'],
            ['route_number' => '428', 'route_name' => 'M. Yamin - Rawang Panjang', 'color' => 'blue'],
            ['route_number' => '430', 'route_name' => 'Permindo - Perum Belimbing', 'color' => 'red'],
            ['route_number' => '430A', 'route_name' => 'Permindo - Balai Baru/SMPN 18', 'color' => 'green'],
            ['route_number' => '433', 'route_name' => 'Pangkalan Angkot - Teluk Bayur', 'color' => 'darkblue'],
            ['route_number' => '434', 'route_name' => 'M. Yamin - Teluk Bayur', 'color' => 'darkblue'],
            ['route_number' => '436', 'route_name' => 'M. Yamin - Tarantang Baringin', 'color' => 'blue'],
            ['route_number' => '437', 'route_name' => 'M. Yamin - Teluk Kabung', 'color' => 'blue'],
            ['route_number' => '439A', 'route_name' => 'M. Yamin - Balai Kota Aia Pac', 'color' => 'purple'],
            ['route_number' => '440', 'route_name' => 'Permindo - Balai Kota Aia Paca', 'color' => 'purple'],
            ['route_number' => '444', 'route_name' => 'M. Yamin - Balai Kota Aia Pacah', 'color' => 'purple'],
            ['route_number' => '444A', 'route_name' => 'M. Yamin - Tanjung Aur', 'color' => 'purple'],
            ['route_number' => '444B', 'route_name' => 'M. Yamin - Sungai Lareh', 'color' => 'purple'],
            ['route_number' => '448', 'route_name' => 'Permindo - Kampus UNAND Limau Manis', 'color' => 'green'],
        ];

        DB::table('angkot_types')->insert($data);
    }
}
