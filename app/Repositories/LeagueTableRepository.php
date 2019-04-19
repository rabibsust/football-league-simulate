<?php

namespace App\Repositories;

interface LeagueTableRepository {
    public function search(string $query = ""): Collection;
}