<?php

namespace App\Helpers;

class Message
{
    public static function MainMenu()
    {
        $message = "📺 <b>Bu bot bilan sevimli kontentingizni topish va yuklab olish juda qulay.</b>\n\n" .
            "✨ <b>Endi barcha ijtimoiy tarmoqlardagi videolar va musiqalar bitta botda!</b>\n\n" .
            "🚀 <b><u>Super video yuklash bo'limi:</u></b>\n\n" .
            "<b>• TikTok</b> – <i>Reels</i>\n<b>• Likee</b> – <i>Tuzatilmoqda</i>\n" .
            "<b>• Pinterest</b> – <i>Tuzatilmoqda</i>\n<b>• Instagram</b> – <i>Reels, Stories, IGTV</i>\n" .
            "<b>• YouTube</b> – <i>Tuzatilmoqda</i>\n\n" .
            "🎵 <b><u>Super musiqa izlash bo'limi:</u></b>\n\n<b>–</b> <b>Qo'shiq nomi yoki ijrochi nomi.</b>\n" .
            "<b>–</b> <b>Qo'shiq qisqa matni bo'yicha.</b>";
        return $message;
    }

    public static function AboutMenu()
    {
        return "ABOUT";
    }

    public static function PremiumMenu()
    {
        return "PREMIUM";
    }

    public static function GroupMenu()
    {
        return "GROUP";
    }

    public static function PrivacyMenu()
    {
        $message = "<blockquote expandable>ℹ️ <b><u>Bizning botdan foydalanishda quyidagi qoidalarga rioya qilishingizni so'raymiz:</u></b>\n\n" .
            "📜 <b>Mualliflik huquqi:</b> Yuklab olinadigan kontent mualliflik huquqi bilan himoyalangan bo'lishi mumkin. Mualliflik huquqini buzadigan har qanday harakat uchun siz javobgarsiz.\n\n" .
            "📋 <b>Platforma siyosatlari:</b> Har bir platformaning foydalanish shartlariga rioya qiling. Ushbu shartlarga zid bo'lgan har qanday harakatdan saqlaning.\n\n" .
            "⚠️ <b>Javobgarlik:</b> Ushbu bot orqali amalga oshiriladigan har qanday mualliflik huquqi buzilishlari uchun biz javobgar emasmiz. Har bir foydalanuvchi o'z harakatlari uchun o'zi javobgar.\n\n" .
            "📌 <b>Eslatma:</b> Bizning botdan foydalanishda ushbu qoidalarni qabul qilishingiz va ularga rioya qilishingizni so'raymiz.</blockquote>";
        return $message;
    }

    public static function GenderMenu()
    {
        return "🚻 <b>Botdan foydalanish uchun jinsingizni tanlang, bu sizga to'g'ri reklama yuborishimizga yordam beradi.</b>";
    }

    public static function PrivacyChkd()
    {
        return "✅ Siz qoidalarga rozilik bildirdingiz.";
    }

    public static function GenderChkd()
    {
        return "✅ Jins muvaffaqiyatli tanlandi!";
    }
}
