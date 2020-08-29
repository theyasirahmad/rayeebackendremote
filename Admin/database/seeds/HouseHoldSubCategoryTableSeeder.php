<?php

use Illuminate\Database\Seeder;
use App\Models\house_hold_sub_category;

class HouseHoldSubCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subCategory = array(
            "Confectionery (Biscuits, cakes, Chocolates etc)" => "1",
            "Canned foods (Pickles, Seafood etc)" => "1",
            "Cereals (Breakfast cereals, kids Cereals etc)" => "1",
            "Chocolates , Mints & Gums" => "1",
            "Spices" => "1",
            "Cooking Oil & Ghee" => "1",
            "Jam, Spreads, & Honey" => "1",
            "Pasta & Instant Noodles" => "1",
            "Rice & Flour" => "1",
            "Ketchups, Vinegars, Sauces" => "1",
            "Babyfood (Cerelac , Bisuits etc)" => "2",
            "Baby toiletries (Shampoo , lotion, skin care etc)" => "2",
            "Diapers & Wipes" => "2",
            "Baby Milk powder" => "2",
            "Margarine, Butter, Cheese" => "3",
            "Frozen food (Nuggets, Poultry, Seafood , Frozen chips, & Ready to eat meals" => "3",
            "Ice Cream" => "3",
            "Packaged Juices (Liquid & Powdered)" => "3",
            "Packaged Milk (Flavored, Full cream & low-Fat milk)" => "3",
            "Carbonated Soft Drinks" => "4",
            "Sports & Energy Drinks" => "4",
            "Tea & Coffee" => "4",
            "Bottled Water" => "4",
            "Bath Toiletries (Bar soap, Liquid Bodywash, Liquid Hand soap)" => "5",
            "Deodorants & Lotion" => "5",
            "Feminine care (Sanitary Pads, Hair removing cream etc.)" => "5",
            "Shampoo & Conditioner" => "5",
            "Mens Shaving (Razors, & After shave cream & lotion)" => "5",
            "Oral Care (Toothpaste, Mouth wash etc.)" => "5",
            "Oral Care (Toothpaste, Mouth wash etc.)" => "5",
            "Skin Care & Cosmetics" => "6",
            "Air Fresheners" => "6",
            "Floor Cleaners" => "6",
            "Insect Killer" => "6",
            "Kitchen Cleaning (Dishwashing soap & liquid, sponges & Scourers)" => "6",
            "Laundry (Powder & liquid detergent)" => "6",
            "LED & energy saving Bulbs" => "6",
            "Paper & Cotton products (Tissues & toilet paper)" => "6",
            "Toilet cleaners" => "6",
            "Cigrattes / Cigars etc" => "7",
        );
        foreach($subCategory as $key=>$val){
            house_hold_sub_category::create([
                'title' => $key,
                'main_cat' => $val,
            ]);
        }
    }
}
