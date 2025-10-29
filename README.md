<p align="center">
  <span style="font-size: 80px; color: red; font-weight: bold;">KILM</span>
</p>

<p align="center" style="max-width: 700px; text-align: justify; margin: 20px auto; font-size: 16px; line-height: 1.6;">
  Projekta galvenais mērķis ir palīdzēt lietotājiem vieglāk izvēlēties piemērotu filmu skatīšanai, piedāvājot personalizētus filmu ieteikumus, kas balstīti uz viņu vēlmēm un skatīšanās vēsturi. Tā risina bieži sastopamo problēmu - grūtības izvēlēties, ko skatīties vakarā, piedāvājot automatizētu un lietotājam pielāgotu risinājumu.
</p>

## Kā setup projektu

1. Nokopē https://github.com/Kkira0/kv-darbs.git
2. Vietā, kur vēlies, lai projekts atrodas ievada rindiņu git clone https://github.com/Kkira0/kv-darbs.git
3. composer install
4. cp .env.example .env

## Iesakāms rediģēt .env failu uz mysql, bet nav obligāti

5. php artisan key:generate
6. php artisan migrate
7. php artisan db:seed --class=MovieDatabaseSeeder
8. php artisan serve

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
