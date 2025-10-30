<p style="text-align: center; margin-top: 50px;">
  <span style="font-size: 80px; color: red; font-weight: bold; font-family: 'Arial Black', sans-serif;">KILM</span>
</p>

<div style="max-width: 700px; margin: 20px auto; font-size: 18px; line-height: 1.8; text-align: justify; color: #333; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
  Projekta galvenais mērķis ir palīdzēt lietotājiem vieglāk izvēlēties piemērotu filmu skatīšanai, piedāvājot personalizētus filmu ieteikumus, kas balstīti uz viņu vēlmēm un skatīšanās vēsturi. Tā risina bieži sastopamo problēmu – grūtības izvēlēties, ko skatīties vakarā, piedāvājot automatizētu un lietotājam pielāgotu risinājumu.
</div>

<div style="max-width: 700px; margin: 40px auto; font-size: 16px; line-height: 1.6; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
  <h2 style="text-align: center; color: #444;">Kā setup projektu</h2>
  <ol>
    <li>Nokopē <code>https://github.com/Kkira0/kv-darbs.git</code></li>
    <li>Vietā, kur vēlies, lai projekts atrodas, ievadi: <code>git clone https://github.com/Kkira0/kv-darbs.git</code></li>
    <li><code>composer install</code></li>
    <li><code>cp .env.example .env</code></li>
    <li><code>php artisan key:generate</code></li>
    <li><code>php artisan migrate</code></li>
    <li><code>php artisan db:seed --class=MovieDatabaseSeeder</code></li>
    <li><code>php artisan serve</code></li>
  </ol>
</div>

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
