<?php

/**
 * S — Single Responsibility
 * Завдання: клас нижче і «тягне» дані, і рендерить HTML. Розділи відповідальності: окремо сховище даних та рендерер.
 * Координатор має лише збирати їх докупи.
 *
 * Є клас репозиторію (наприклад, UserReportRepository) і окремий рендерер (UserReportHtmlRenderer).
 * «Координатор» (контролер/сервіс) не знає деталей ані БД, ані HTML.
 * Вивід лишається тим самим (<ul><li>1: Denys</li></ul>).
 */



// class UserReport
// {
//     public function getData(): array
//     {
//         // Уявні дані з БД
//         return [['id' => 1, 'name' => 'Denys']];
//     }

//     public function renderHtml(array $rows): string
//     {
//         $html = '<ul>';
//         foreach ($rows as $r) {
//             $html .= "<li>{$r['id']}: {$r['name']}</li>";
//         }
//         return $html . '</ul>';
//     }

//     public function exportHtml(): string
//     {
//         return $this->renderHtml($this->getData());
//     }
// }

// echo (new UserReport())->exportHtml();



class UserReportRepository
{
    public function getData(): array
    {
        return [['id' => 1, 'name' => 'Denys']];
    }
}

class UserReportHtmlRenderer
{
    public function render(array $rows): string
    {
        $html = '<ul>';
        foreach ($rows as $r) {
            $html .= "<li>{$r['id']}: {$r['name']}</li>";
        }
        return $html . '</ul>';
    }
}

class UserReport
{   
    private $repository;
    private $renderer;
    public function __construct( $repository, $renderer) 
    {
        $this->repository = $repository;
        $this->renderer = $renderer;
    }
    
    public function exportHtml(): string
    {
        $rows = $this->repository->getData();
        return $this->renderer->render($rows);
    }
}

$repository = new UserReportRepository();
$renderer = new UserReportHtmlRenderer();
$report = new UserReport($repository, $renderer);

echo $report->exportHtml();