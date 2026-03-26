<style>
body.student-portal-page #container {
    max-width: 1600px !important;
    width: calc(100% - 28px) !important;
    margin: 18px auto !important;
    padding: 18px !important;
}
body.student-portal-page #header,
body.student-portal-page #menu,
body.student-portal-page #footer {
    width: 100% !important;
    margin-left: 0 !important;
}
body.student-portal-page #header {
    height: auto !important;
    min-height: 100px;
    padding: 0 !important;
}
body.student-portal-page #menu {
    margin: 0 0 24px !important;
    position: relative;
    z-index: 80;
    overflow: visible;
}
body.student-portal-page #menubar1 {
    width: 100% !important;
    margin: 0 !important;
    min-height: 52px;
    height: auto !important;
    border-radius: 16px;
    position: relative;
    z-index: 90;
    overflow: visible;
}
body.student-portal-page #menubar1 ul {
    position: relative;
    z-index: 91;
    overflow: visible;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 12px;
    margin: 0 !important;
    padding: 10px 18px !important;
}
body.student-portal-page #menubar1 ul li {
    float: none !important;
    padding: 0 !important;
}
body.student-portal-page #menubar1 ul li a {
    margin: 0 !important;
    min-height: 38px;
    line-height: 1.2 !important;
    display: flex !important;
    align-items: center;
    justify-content: center;
}
body.student-portal-page .main-row {
    position: relative;
    z-index: 1;
    display: flex !important;
    flex-direction: row !important;
    gap: 28px !important;
    align-items: flex-start !important;
}
body.student-portal-page .main-row > #left {
    flex: 0 0 290px !important;
    width: auto !important;
    min-width: 0 !important;
}
body.student-portal-page .main-row > #content {
    flex: 1 1 auto !important;
    width: auto !important;
    min-width: 0 !important;
    margin-left: 0 !important;
    height: auto !important;
}
body.student-portal-page .main-row > #sidebar {
    flex: 0 0 300px !important;
    width: auto !important;
    min-width: 0 !important;
}
body.student-portal-page #content,
body.student-portal-page #contentindex5,
body.student-portal-page #contentindex55 {
    width: 100% !important;
    height: auto !important;
    margin-left: 0 !important;
}
@media (max-width: 1100px) {
    body.student-portal-page #container {
        width: calc(100% - 20px) !important;
        padding: 14px !important;
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
    body.student-portal-page #container {
        width: calc(100% - 12px) !important;
        padding: 10px !important;
    }
    body.student-portal-page #menubar1 ul {
        justify-content: stretch;
        padding: 10px !important;
    }
    body.student-portal-page #menubar1 ul li,
    body.student-portal-page #menubar1 ul li a {
        width: 100%;
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
