<?php

/**
 * Незмінний об'єкт електронного листа
 */
class Email
{
    private readonly string $to;
    private readonly string $subject;
    private readonly string $body;
    private readonly array $cc;
    private readonly array $attachments;

    public function __construct(string $to, string $subject, string $body = '', array $cc = [], array $attachments = [])
    {
        $this->to = $to;
        $this->subject = $subject;
        $this->body = $body;
        $this->cc = $cc;
        $this->attachments = $attachments;
    }

    public function __toString(): string
    {
        $result = "To: {$this->to}\n";
        $result .= "Subject: {$this->subject}\n";

        if (!empty($this->cc)) {
            $result .= "CC: " . implode(', ', $this->cc) . "\n";
        }

        if (!empty($this->attachments)) {
            $result .= "Attachments: " . implode(', ', $this->attachments) . "\n";
        }

        $result .= "\n{$this->body}";

        return $result;
    }
}








/**
 * Builder для поетапного складання об'єкта Email
 */
class EmailBuilder
{
    private ?string $to = null;
    private ?string $subject = null;
    private string $body = '';
    private array $cc = [];
    private array $attachments = [];

    /**
     * Встановлює адресу отримувача (обов'язкове поле)
     */
    public function to(string $to): self
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Встановлює тему листа (обов'язкове поле)
     */
    public function subject(string $subject): self
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Встановлює тіло листа
     */
    public function body(string $body): self
    {
        $this->body = $body;
        return $this;
    }

    /**
     * Додає адресу в копію (можна викликати кілька разів)
     */
    public function addCc(string $ccEmail): self
    {
        $this->cc[] = $ccEmail;
        return $this;
    }

    /**
     * Додає кілька адрес в копію одразу
     */
    public function cc(array $ccEmails): self
    {
        $this->cc = array_merge($this->cc, $ccEmails);
        return $this;
    }

    /**
     * Додає вкладення (можна викликати кілька разів)
     */
    public function addAttachment(string $filePath): self
    {
        $this->attachments[] = $filePath;
        return $this;
    }

    /**
     * Додає кілька вкладень одразу
     */
    public function attachments(array $filePaths): self
    {
        $this->attachments = array_merge($this->attachments, $filePaths);
        return $this;
    }

    /**
     * Створює незмінний об'єкт Email
     * Перевіряє наявність обов'язкових полів
     */
    public function build(): Email
    {
        if ($this->to === null) {
            throw new InvalidArgumentException('Поле "to" є обов\'язковим для створення листа');
        }

        if ($this->subject === null) {
            throw new InvalidArgumentException('Поле "subject" є обов\'язковим для створення листа');
        }

        return new Email(
            $this->to,
            $this->subject,
            $this->body,
            $this->cc,
            $this->attachments
        );
    }
}













// Приклади використання:

echo "=== Приклад 1: Мінімальний лист ===\n";
try {
    $email1 = (new EmailBuilder())
        ->to('user@example.com')
        ->subject('Тестовий лист')
        ->build();

    echo $email1 . "\n\n";
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n\n";
}



echo "=== Приклад 2: Повний лист ===\n";
try {
    $email2 = (new EmailBuilder())
        ->to('recipient@example.com')
        ->subject('Важливе повідомлення')
        ->body('Це тіло листа з важливою інформацією.')
        ->addCc('manager@example.com')
        ->addCc('team@example.com')
        ->addAttachment('/path/to/document.pdf')
        ->addAttachment('/path/to/image.jpg')
        ->build();

    echo $email2 . "\n\n";
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n\n";
}

echo "=== Приклад 3: Лист з масивами CC та вкладень ===\n";
try {
    $email3 = (new EmailBuilder())
        ->to('client@example.com')
        ->subject('Звіт за місяць')
        ->body('Додаємо звіт за поточний місяць.')
        ->cc(['boss@example.com', 'accountant@example.com'])
        ->attachments(['/reports/monthly.xlsx', '/reports/summary.pdf'])
        ->build();

    echo $email3 . "\n\n";
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n\n";
}

echo "=== Приклад 4: Спроба створити лист без обов'язкових полів ===\n";
try {
    $email4 = (new EmailBuilder())
        ->body('Лист без адреси та теми')
        ->build();

    echo $email4 . "\n\n";
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n\n";
}

try {
    $email5 = (new EmailBuilder())
        ->to('user@example.com')
        ->build();

    echo $email5 . "\n\n";
} catch (Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n\n";
}