<?php
if (!defined('CDEOFFICER_POPUP_STYLES_LOADED')) {
    define('CDEOFFICER_POPUP_STYLES_LOADED', true);
    ?>
    <style>
        .cde-popup-card {
            background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
            border: 1px solid #d6e2f0;
            border-radius: 22px;
            padding: 26px;
            color: #163b60;
            box-shadow: 0 20px 40px rgba(15, 44, 76, 0.08);
        }

        .cde-popup-header {
            margin-bottom: 20px;
        }

        .cde-popup-kicker {
            display: inline-block;
            margin-bottom: 8px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #d9e9fb;
            color: #174a7c;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .cde-popup-title {
            margin: 0;
            color: #12395f;
            font-size: 28px;
            line-height: 1.2;
        }

        .cde-popup-copy {
            margin: 10px 0 0;
            color: #4a6480;
            line-height: 1.6;
        }

        .cde-popup-form {
            display: grid;
            gap: 18px;
        }

        .cde-popup-field {
            display: grid;
            gap: 8px;
            color: #173a5e;
            font-weight: 700;
        }

        .cde-popup-grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .cde-popup-input,
        .cde-popup-select,
        .cde-popup-textarea {
            width: 100%;
            border: 1px solid #bfd0e2;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 15px;
            color: #173a5e;
            background: #f9fbfe;
            box-sizing: border-box;
        }

        .cde-popup-textarea {
            min-height: 220px;
            resize: vertical;
            line-height: 1.6;
        }

        .cde-popup-input:focus,
        .cde-popup-select:focus,
        .cde-popup-textarea:focus {
            outline: none;
            border-color: #2f77bd;
            box-shadow: 0 0 0 4px rgba(47, 119, 189, 0.12);
        }

        .cde-popup-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .cde-popup-btn,
        .cde-popup-btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 44px;
            padding: 0 20px;
            border: 0;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: transform 0.18s ease;
        }

        .cde-popup-btn {
            background: #1f6fb2;
            color: #ffffff;
        }

        .cde-popup-btn-secondary {
            background: #edf4fb;
            color: #18466f;
        }

        .cde-popup-btn:hover,
        .cde-popup-btn-secondary:hover {
            transform: translateY(-1px);
        }

        .cde-popup-note {
            margin: 0;
            color: #60748c;
            font-size: 14px;
            line-height: 1.6;
        }

        .cde-popup-list {
            margin: 0;
            padding-left: 18px;
            color: #48637f;
            line-height: 1.7;
        }

        @media (max-width: 720px) {
            .cde-popup-card {
                padding: 18px;
            }

            .cde-popup-grid {
                grid-template-columns: 1fr;
            }

            .cde-popup-actions {
                flex-direction: column;
                align-items: stretch;
            }
        }
    </style>
    <?php
}
?>
