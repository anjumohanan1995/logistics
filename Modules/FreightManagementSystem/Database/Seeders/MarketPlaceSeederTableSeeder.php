<?php

namespace Modules\FreightManagementSystem\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\LandingPage\Entities\MarketplacePageSetting;


class MarketPlaceSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $module = 'FreightManagementSystem';

        $data['product_main_banner'] = '';
        $data['product_main_status'] = 'on';
        $data['product_main_heading'] = 'FreightManagementSystem';
        $data['product_main_description'] = '<p>Effortlessly manage freight, monitor metrics, and streamline payments with Dash SaaS Freight Management Integration. Drive efficiency and success in your logistics operations today.</p>';
        $data['product_main_demo_link'] = '#';
        $data['product_main_demo_button_text'] = 'View Live Demo';
        $data['dedicated_theme_heading'] = 'Efficient Backend Management.';
        $data['dedicated_theme_description'] = '<p>Dash SaaS Freight Management Integration revolutionizes the backend management of logistics operations. Once customers complete their booking process on the front end, you gain immediate access to a suite of powerful tools for efficient freight management. From setting competitive prices to configuring containers and selecting tailored services, the platform empowers you to fine-tune every aspect of your logistics operations according to your unique requirements and preferences.</p>';
        $data['dedicated_theme_sections'] = '[{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Insightful Dashboard Monitoring","dedicated_theme_section_description":"<p>Gain unparalleled insights into your logistics operations with the comprehensive dashboard provided by Dash SaaS Freight Management Integration. This intuitive dashboard serves as your command center, presenting key metrics such as total customers, bookings, shipping, and invoices in a visually engaging and easy-to-understand format. Moreover, you can effortlessly monitor recent invoices and shipping lists, ensuring that you have real-time visibility into the performance of your logistics processes and the status of your shipments.</p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}},{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Efficient Freight Management with Dash SaaS","dedicated_theme_section_description":"<p>Streamline logistics operations, monitor metrics, and simplify payments with Dash SaaS Freight Management Integration. Experience seamless efficiency for your logistics business.</p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}},{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Agile Response with Real-time Updates","dedicated_theme_section_description":"<p>In the dynamic and fast-paced world of logistics, agility is paramount. Dash SaaS Freight Management Integration empowers you to stay ahead of the curve with real-time updates on recent invoices and shipping lists. This invaluable feature enables you to respond promptly to evolving customer needs and market demands, ensuring timely processing and delivery of shipments. By harnessing the power of real-time data, you can optimize your logistics operations, enhance customer satisfaction, and maintain a competitive edge in the market.</p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}},{"dedicated_theme_section_image":"","dedicated_theme_section_heading":"Effortless Payment Management","dedicated_theme_section_description":"<p>Simplify and streamline the payment process with the integrated payment management module offered by Dash SaaS Freight Management Integration. Say goodbye to manual invoicing and tedious payment tracking tasks. With our platform, you can effortlessly generate invoices, track payments, and manage billing cycles with precision and ease. By automating and centralizing your payment processes, you can minimize errors, reduce administrative burdens, and ensure smooth financial transactions, allowing you to focus your time and resources on driving growth and innovation in your logistics business.</p>","dedicated_theme_section_cards":{"1":{"title":null,"description":null}}}]';
        $data['dedicated_theme_sections_heading'] = '';
        $data['screenshots'] = '[{"screenshots":"","screenshots_heading":"FreightManagementSystem"},{"screenshots":"","screenshots_heading":"FreightManagementSystem"},{"screenshots":"","screenshots_heading":"FreightManagementSystem"},{"screenshots":"","screenshots_heading":"FreightManagementSystem"},{"screenshots":"","screenshots_heading":"FreightManagementSystem"}]';
        $data['addon_heading'] = '<h2>Why choose dedicated modules<b> for Your Business?</b></h2>';
        $data['addon_description'] = '<p>With Dash, you can conveniently manage all your business functions from a single location.</p>';
        $data['addon_section_status'] = 'on';
        $data['whychoose_heading'] = 'Why choose dedicated modulesfor Your Business?';
        $data['whychoose_description'] = '<p>With Dash, you can conveniently manage all your business functions from a single location.</p>';
        $data['pricing_plan_heading'] = 'Empower Your Workforce with DASH';
        $data['pricing_plan_description'] = '<p>Access over Premium Add-ons for Accounting, HR, Payments, Leads, Communication, Management, and more, all in one place!</p>';
        $data['pricing_plan_demo_link'] = '#';
        $data['pricing_plan_demo_button_text'] = 'View Live Demo';
        $data['pricing_plan_text'] = '{"1":{"title":"Pay-as-you-go"},"2":{"title":"Unlimited installation"},"3":{"title":"Secure cloud storage"}}';
        $data['whychoose_sections_status'] = 'on';
        $data['dedicated_theme_section_status'] = 'on';

        foreach ($data as $key => $value) {
            if (!MarketplacePageSetting::where('name', '=', $key)->where('module', '=', $module)->exists()) {
                MarketplacePageSetting::updateOrCreate(
                    [
                        'name' => $key,
                        'module' => $module

                    ],
                    [
                        'value' => $value
                    ]
                );
            }
        }
    }
}
