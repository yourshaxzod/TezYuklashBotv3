<?php

namespace App\Services;

use App\Config\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardButton;
use SergiX44\Nutgram\Telegram\Types\Keyboard\InlineKeyboardMarkup;

class YoutubeService
{

    public static function getVideoInfo(Nutgram $bot, string $url): void
    {
        $messageId = $bot->sendMessage(
            text: "🔍 <b>Video ma'lumotlari yuklanmoqda...</b>",
            parse_mode: ParseMode::HTML
        )->message_id;

        try {
            $client = new Client();

            $apiUrl = Config::get('YOUTUBE_API');

            $response = $client->request('GET', $apiUrl, [
                'query' => [
                    'url' => $url
                ],
                'timeout' => 30,
            ]);

            $responseData = json_decode($response->getBody()->getContents(), true);

            if (!isset($responseData['status']) || !$responseData['status']) {
                throw new \Exception($responseData['error'] ?? 'Video ma\'lumotlarini olishda xatolik yuz berdi.');
            }

            $data = $responseData['data'];

            $title = $data['title'] ?? 'Noma\'lum video';
            $author = $data['author'] ?? 'Noma\'lum kanal';
            $channel = !empty($author) ? "#$author" : '';
            $channel = str_replace(' ', '_', $channel);
            $description = $data['description'] ?? '';
            $thumbnailUrl = $data['thumbnail'] ?? '';

            $message = "📹 <b>{$title}</b>\n";

            if (!empty($channel)) {
                $message .= "{$channel} →\n";
            }

            $qualityInfo = '';
            $formats = [];
            $qualityEmojis = [
                '144p' => '⚡️',
                '240p' => '⚡️',
                '480p' => '⚡️',
                '720p' => '⚡️',
                '1080p' => '⚡️',
                '2K' => '⚡️',
                '4K' => '⚡️'
            ];

            if (isset($data['formats']) && is_array($data['formats'])) {
                $formats = $data['formats'];

                usort($formats, function ($a, $b) {
                    $qualityOrder = [
                        'MP3' => 0,
                        '144p' => 1,
                        '240p' => 2,
                        '360p' => 3,
                        '480p' => 4,
                        '720p' => 5,
                        '1080p' => 6,
                        '2K' => 7,
                        '4K' => 8
                    ];

                    $orderA = $qualityOrder[$a['quality']] ?? 999;
                    $orderB = $qualityOrder[$b['quality']] ?? 999;

                    return $orderA - $orderB;
                });

                foreach ($formats as $format) {
                    if ($format['quality'] !== 'MP3') {
                        $quality = $format['quality'];
                        $emoji = $qualityEmojis[$quality] ?? '📹';
                        $filesize = self::formatFileSize($format['filesize'] ?? null);
                        $qualityInfo .= "{$emoji} {$quality}: {$filesize}\n";
                    }
                }
            }

            $message .= "\n{$qualityInfo}";
            $message .= "Форматы для скачивания ⬇️";

            $keyboard = InlineKeyboardMarkup::make();

            $videoButtons = [];
            $videoFormats = array_filter($formats, function ($format) {
                return $format['quality'] !== 'MP3';
            });

            foreach ($videoFormats as $format) {
                $quality = $format['quality'];
                $formatId = $format['format_id'];
                $emoji = $qualityEmojis[$quality] ?? '📹';

                $videoButtons[] = InlineKeyboardButton::make(
                    "{$emoji} {$quality}",
                    callback_data: "download_video_{$formatId}"
                );
            }

            $rows = array_chunk($videoButtons, 3);
            foreach ($rows as $row) {
                $keyboard->addRow(...$row);
            }

            $mp3Button = null;
            foreach ($formats as $format) {
                if ($format['quality'] === 'MP3') {
                    $mp3Button = InlineKeyboardButton::make(
                        text: "🔊 MP3",
                        callback_data: "download_audio_{$format['format_id']}"
                    );
                    break;
                }
            }

            $previewButton = InlineKeyboardButton::make(
                "🖼 Превью",
                callback_data: "preview_thumb"
            );

            if ($mp3Button) {
                $keyboard->addRow($mp3Button, $previewButton);
            } else {
                $keyboard->addRow($previewButton);
            }

            if (!empty($thumbnailUrl)) {
                $bot->sendPhoto(
                    photo: $thumbnailUrl,
                    caption: $message,
                    parse_mode: ParseMode::HTML,
                    reply_markup: $keyboard
                );
                $bot->deleteMessage($bot->chatId(), $messageId);
            } else {
                $bot->editMessageText(
                    text: $message,
                    chat_id: $bot->chatId(),
                    message_id: $messageId,
                    parse_mode: ParseMode::HTML,
                    reply_markup: $keyboard
                );
            }
        } catch (GuzzleException $e) {
            $bot->editMessageText(
                text: "❌ <b>Xatolik:</b> Video serverga ulanishda muammo yuzaga keldi. Iltimos, keyinroq qayta urinib ko'ring.",
                chat_id: $bot->chatId(),
                message_id: $messageId,
                parse_mode: ParseMode::HTML
            );
        } catch (\Exception $e) {
            $bot->editMessageText(
                text: "❌ <b>Xatolik:</b> " . $e->getMessage(),
                chat_id: $bot->chatId(),
                message_id: $messageId,
                parse_mode: ParseMode::HTML
            );
        }
    }

    private static function formatFileSize(?int $bytes): string
    {
        if ($bytes === null) {
            return "Nomalum";
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes) . $units[$pow];
    }
}
