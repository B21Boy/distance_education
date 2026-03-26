<style>
body.student-portal-page #container {
    max-width: 1600px !important;
    width: calc(100% - 28px) !important;
}
body.student-portal-page .main-row {
    display: flex !important;
    flex-direction: row !important;
    gap: 28px !important;
    align-items: flex-start !important;
}
body.student-portal-page .main-row > #left {
    flex: 0 0 290px !important;
}
body.student-portal-page .main-row > #content {
    flex: 1 1 auto !important;
    min-width: 0 !important;
}
body.student-portal-page .main-row > #sidebar {
    flex: 0 0 300px !important;
}
body.student-portal-page .sidebar-panel {
    margin-bottom: 22px;
    overflow: hidden;
    border: 1px solid #d9e4ef;
    border-radius: 20px;
    background: linear-gradient(180deg, #ffffff 0%, #f6f9fd 100%);
    box-shadow: 0 18px 32px rgba(16, 46, 74, 0.08);
}
body.student-portal-page .sidebar-panel-title {
    padding: 16px 20px;
    background: linear-gradient(135deg, #12395f 0%, #245f96 100%);
    color: #ffffff;
    font-size: 16px;
    font-weight: 800;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}
body.student-portal-page .sidebar-panel-body {
    padding: 22px;
    color: #35516d;
}
body.student-portal-page .sidebar-profile-name {
    margin-bottom: 16px;
    line-height: 1.7;
    font-size: 16px;
    color: #163b60;
}
body.student-portal-page .sidebar-profile-name strong {
    color: #0f2f4e;
}
body.student-portal-page .profile-thumb {
    display: block;
    width: 220px;
    height: 190px;
    margin: 0 auto 18px;
    border-radius: 18px;
    object-fit: cover;
    border: 1px solid #d6e3ef;
    background: #edf3f9;
}
body.student-portal-page .sidebar-action-list,
body.student-portal-page .sidebar-social-links {
    display: grid;
    gap: 12px;
    margin: 0;
    padding: 0;
    list-style: none;
}
body.student-portal-page .sidebar-action-list a,
body.student-portal-page .sidebar-social-links a {
    display: block;
    padding: 13px 15px;
    border-radius: 14px;
    text-decoration: none;
    font-size: 15px;
    font-weight: 700;
    color: #18466f;
    background: #edf4fb;
    transition: background-color 0.18s ease, transform 0.18s ease;
}
body.student-portal-page .sidebar-action-list a:hover,
body.student-portal-page .sidebar-social-links a:hover {
    background: #dbeafb;
    transform: translateY(-1px);
}
body.student-portal-page .admin-page-shell {
    background: linear-gradient(180deg, #f8fbff 0%, #eef4fb 100%);
    border: 1px solid #d6e2f0;
    border-radius: 18px;
    padding: 24px;
    box-shadow: 0 20px 40px rgba(15, 44, 76, 0.08);
}
body.student-portal-page .admin-page-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 16px;
    margin-bottom: 22px;
}
body.student-portal-page .admin-page-kicker {
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
body.student-portal-page .admin-page-title {
    margin: 0;
    color: #12395f;
    font-size: 28px;
}
body.student-portal-page .admin-page-copy {
    margin: 10px 0 0;
    max-width: 760px;
    color: #4a6480;
    line-height: 1.6;
}
body.student-portal-page .admin-page-panel {
    background: #ffffff;
    border: 1px solid #dce6f2;
    border-radius: 16px;
    padding: 20px;
}
body.student-portal-page .admin-page-toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 18px;
}
body.student-portal-page .admin-page-form-row {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
body.student-portal-page .admin-page-input,
body.student-portal-page .admin-page-select {
    width: 100%;
    max-width: 320px;
    min-height: 42px;
    border: 1px solid #bfd0e2;
    border-radius: 10px;
    padding: 0 14px;
    font-size: 15px;
    color: #173a5e;
    background: #f9fbfe;
    box-sizing: border-box;
}
body.student-portal-page .admin-page-input:focus,
body.student-portal-page .admin-page-select:focus {
    outline: none;
    border-color: #2f77bd;
    box-shadow: 0 0 0 4px rgba(47, 119, 189, 0.12);
}
body.student-portal-page .admin-page-btn,
body.student-portal-page .admin-page-btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 42px;
    border: 0;
    border-radius: 10px;
    padding: 0 18px;
    font-size: 14px;
    font-weight: 700;
    text-decoration: none;
    cursor: pointer;
    transition: transform 0.18s ease;
}
body.student-portal-page .admin-page-btn {
    background: #1f6fb2;
    color: #ffffff;
}
body.student-portal-page .admin-page-btn-secondary {
    background: #edf4fb;
    color: #18466f;
}
body.student-portal-page .admin-page-btn:hover,
body.student-portal-page .admin-page-btn-secondary:hover {
    transform: translateY(-1px);
}
body.student-portal-page .admin-page-status-card,
body.student-portal-page .admin-page-empty {
    padding: 18px 20px;
    border-radius: 14px;
    background: #f8fbff;
    border: 1px dashed #bfd0e2;
    color: #48637f;
}
body.student-portal-page .admin-page-table-wrap {
    overflow-x: auto;
    border: 1px solid #e3ebf3;
    border-radius: 14px;
}
body.student-portal-page .admin-page-table {
    width: 100%;
    min-width: 760px;
    border-collapse: collapse;
    background: #ffffff;
}
body.student-portal-page .admin-page-table th {
    background: #eff5fb;
    color: #12395f;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
body.student-portal-page .admin-page-table th,
body.student-portal-page .admin-page-table td {
    padding: 14px 16px;
    border-bottom: 1px solid #e7edf5;
    text-align: left;
    vertical-align: top;
}
body.student-portal-page .admin-page-table tr:last-child td {
    border-bottom: 0;
}
body.student-portal-page .admin-page-pagination {
    margin-top: 18px;
    text-align: center;
}
@media (max-width: 1100px) {
    body.student-portal-page #container {
        width: calc(100% - 20px) !important;
    }
    body.student-portal-page .main-row {
        flex-direction: column !important;
    }
    body.student-portal-page .main-row > #left,
    body.student-portal-page .main-row > #content,
    body.student-portal-page .main-row > #sidebar {
        width: 100% !important;
        max-width: 100% !important;
        flex: 1 1 auto !important;
    }
}
@media (max-width: 720px) {
    body.student-portal-page .admin-page-shell,
    body.student-portal-page .admin-page-panel {
        padding: 16px;
    }
    body.student-portal-page .admin-page-form-row,
    body.student-portal-page .admin-page-input,
    body.student-portal-page .admin-page-select,
    body.student-portal-page .admin-page-btn,
    body.student-portal-page .admin-page-btn-secondary {
        width: 100%;
        max-width: 100%;
    }
    body.student-portal-page .profile-thumb {
        width: 200px;
        height: 172px;
    }
}
</style>
<div class="student-header-inner">
    <div class="student-header-media student-header-media-left">
        <img src="../images/Bahir_Dar_University_logo.png" alt="Bahir Dar University logo">
    </div>
    <div class="student-header-copy">
        <div id="headtitl">
            <span class="student-header-line">Web Based Distance Education Management System</span>
            <span class="student-header-line">For</span>
            <span class="student-header-line">Bahir Dar University</span>
        </div>
    </div>
    <div class="student-header-media student-header-media-right">
        <img src="../images/bg.jpg" alt="Education background">
    </div>
</div>
