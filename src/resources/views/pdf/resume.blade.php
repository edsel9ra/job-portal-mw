<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Currículum – {{ $candidate->user->name }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            margin: 0;
        }

        body {
            font-family: "DejaVu Sans", Arial, sans-serif;
            font-size: 10pt;
            color: #0f172a;
            line-height: 1.5;
            background: #ffffff;
            margin: 0;
        }

        .page {
            width: 100%;
        }

        .wrapper {
            display: table;
            width: 100%;
            table-layout: fixed;
        }

        /* SIDEBAR - 1/3 compacto */
        .sidebar {
            display: table-cell;
            width: 33%;
            background: #0f172a;
            color: #ffffff;
            padding: 22px 14px 20px;
            vertical-align: top;
        }

        .sidebar-accent {
            height: 4px;
            width: 44px;
            background: #dc2626;
            border-radius: 10px;
            margin: 0 auto 12px;
        }

        .avatar-wrap {
            text-align: center;
            margin-bottom: 12px;
        }

        .avatar-img-wrap {
            width: 82px;
            height: 82px;
            margin: 0 auto;
            border-radius: 41px;
            overflow: hidden;
            border: 3px solid #dc2626;
            background: #111827;
        }

        .avatar-img {
            width: 82px;
            height: 82px;
        }

        .avatar-fallback {
            width: 82px;
            height: 82px;
            line-height: 82px;
            border-radius: 41px;
            background: #111827;
            border: 3px solid #dc2626;
            color: #ffffff;
            text-align: center;
            font-weight: bold;
            font-size: 22px;
            margin: 0 auto;
        }

        .sidebar-name {
            font-size: 11pt;
            font-weight: 900;
            line-height: 1.15;
            margin-bottom: 4px;
            text-align: center;
            word-break: break-word;
        }

        .sidebar-subtitle {
            font-size: 7.5pt;
            color: #cbd5e1;
            margin-bottom: 12px;
            text-align: center;
        }

        .sidebar-tag {
            display: block;
            width: 100%;
            text-align: center;
            font-size: 6.5pt;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            color: #fecaca;
            background: #7f1d1d;
            border-radius: 999px;
            padding: 5px 7px;
            margin-bottom: 14px;
        }

        .sidebar-block {
            margin-top: 13px;
        }

        .sidebar-title {
            font-size: 6.7pt;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fca5a5;
            border-bottom: 1px solid #334155;
            padding-bottom: 4px;
            margin-bottom: 7px;
        }

        .contact-item {
            margin-bottom: 6px;
        }

        .contact-label {
            color: #94a3b8;
            font-size: 6.7pt;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 1px;
        }

        .contact-value {
            color: #e5e7eb;
            font-size: 7.7pt;
            line-height: 1.35;
            word-break: break-word;
        }

        .skill {
            display: inline-block;
            border: 1px solid #475569;
            background: #1e293b;
            color: #f8fafc;
            font-size: 7pt;
            font-weight: 700;
            padding: 3px 6px;
            border-radius: 999px;
            margin: 4px 4px 4px 0;
        }

        .lang-row {
            display: table;
            width: 100%;
            margin-bottom: 5px;
            border-bottom: 1px solid #1e293b;
            padding-bottom: 4px;
        }

        .lang-name {
            display: table-cell;
            font-size: 7.7pt;
            font-weight: 700;
            color: #f8fafc;
        }

        .lang-level {
            display: table-cell;
            text-align: right;
            font-size: 7pt;
            color: #cbd5e1;
        }

        .cert-item {
            margin-bottom: 7px;
        }

        .cert-name {
            font-weight: 800;
            font-size: 7.6pt;
            line-height: 1.3;
            color: #ffffff;
        }

        .cert-meta {
            font-size: 7pt;
            color: #cbd5e1;
            margin-top: 1px;
            line-height: 1.3;
        }

        /* CONTENT */
        .content {
            display: table-cell;
            width: 67%;
            padding: 26px 26px 26px;
            vertical-align: top;
            background: #ffffff;
        }

        .main-header {
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 2px solid #e2e8f0;
            position: relative;
        }

        .header-accent {
            width: 64px;
            height: 5px;
            background: #dc2626;
            border-radius: 10px;
            margin-bottom: 12px;
        }

        .page-name {
            font-size: 24pt;
            font-weight: 900;
            letter-spacing: -0.6px;
            color: #0f172a;
            line-height: 1.1;
        }

        .page-subtitle {
            font-size: 10pt;
            font-weight: 700;
            color: #475569;
            margin-top: 6px;
        }

        .top-meta {
            margin-top: 9px;
            font-size: 8.4pt;
            color: #64748b;
        }

        .section {
            margin-top: 22px;
        }

        .section-title-wrap {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            border-bottom: 1.5px solid #e5e7eb;
            padding-bottom: 8px;
        }

        .section-title {
            display: table-cell;
            font-size: 8pt;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1.1px;
            color: #0f172a;
        }

        .section-marker {
            display: table-cell;
            width: 55px;
            text-align: right;
            color: #dc2626;
            font-size: 8pt;
            font-weight: 900;
        }

        .summary {
            font-size: 10pt;
            color: #334155;
            line-height: 1.75;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-left: 5px solid #dc2626;
            border-radius: 12px;
            padding: 14px 15px;
        }

        .entry {
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 13px;
            margin-bottom: 11px;
            background: #ffffff;
        }

        .entry-top {
            display: table;
            width: 100%;
        }

        .entry-main {
            display: table-cell;
            vertical-align: top;
            padding-right: 10px;
        }

        .entry-meta {
            display: table-cell;
            text-align: right;
            vertical-align: top;
            width: 170px;
        }

        .entry-title {
            font-size: 10.6pt;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.25;
        }

        .entry-subtitle {
            font-size: 9.1pt;
            font-weight: 700;
            color: #475569;
            margin-top: 3px;
        }

        .entry-date {
            display: inline-block;
            font-size: 7.8pt;
            font-weight: 800;
            color: #64748b;
            background: #f1f5f9;
            border-radius: 999px;
            padding: 4px 8px;
        }

        .entry-desc {
            margin-top: 9px;
            font-size: 9pt;
            color: #475569;
            line-height: 1.65;
        }

        .empty-text {
            font-size: 8.6pt;
            color: #94a3b8;
            font-style: italic;
        }

        .footer {
            position: fixed;
            bottom: 12px;
            left: 36%;
            right: 26px;
            font-size: 7.2pt;
            color: #94a3b8;
            border-top: 1px solid #e5e7eb;
            padding-top: 6px;
            text-align: right;
        }

        .footer .page-number:after {
            content: counter(page);
        }

        .footer .page-count:after {
            content: counter(pages);
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="wrapper">
            <!-- SIDEBAR -->
            <div class="sidebar">
                <div class="sidebar-accent"></div>

                <div class="avatar-wrap">
                    @if($photoBase64)
                        <div class="avatar-img-wrap">
                            <img src="{{ $photoBase64 }}" alt="Foto del candidato" class="avatar-img">
                        </div>
                    @else
                        <div class="avatar-fallback">
                            {{ $initials }}
                        </div>
                    @endif
                </div>

                <!--<div class="sidebar-name">
                    {{ $candidate->user->name }}
                </div>

                <div class="sidebar-subtitle">
                    Hoja de vida profesional
                </div>

                <div class="sidebar-tag">
                    Perfil candidato
                </div>-->

                @if($candidate->user->email || $candidate->phone || $candidate->city || $candidate->document_number || $candidate->birth_date)
                    <div class="sidebar-block">
                        <div class="sidebar-title">Contacto</div>

                        @if($candidate->user->email)
                            <div class="contact-item">
                                <div class="contact-label">Correo</div>
                                <div class="contact-value">
                                    {{ $candidate->user->email }}
                                </div>
                            </div>
                        @endif

                        @if($candidate->phone)
                            <div class="contact-item">
                                <div class="contact-label">Celular</div>
                                <div class="contact-value">
                                    {{ $candidate->phone }}
                                </div>
                            </div>
                        @endif

                        @if($candidate->city)
                            <div class="contact-item">
                                <div class="contact-label">Ciudad</div>
                                <div class="contact-value">
                                    {{ $candidate->city }}
                                </div>
                            </div>
                        @endif

                        @if($candidate->document_type || $candidate->document_number)
                            <div class="contact-item">
                                <div class="contact-label">Documento</div>
                                <div class="contact-value">
                                    {{ $candidate->document_type ?? '' }}
                                    @if($candidate->document_type && $candidate->document_number)
                                        ·
                                    @endif
                                    {{ $candidate->document_number ?? '' }}
                                </div>
                            </div>
                        @endif

                        @if($candidate->birth_date)
                            <div class="contact-item">
                                <div class="contact-label">Nacimiento</div>
                                <div class="contact-value">
                                    {{ \Carbon\Carbon::parse($candidate->birth_date)->format('d/m/Y') }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                @if(!empty($resume->skills) && is_array($resume->skills))
                    <div class="sidebar-block">
                        <div class="sidebar-title">Habilidades</div>

                        @foreach($resume->skills as $skill)
                            @if(!empty($skill))
                                <span class="skill">
                                    {{ $skill }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if(!empty($resume->languages) && is_array($resume->languages))
                    <div class="sidebar-block">
                        <div class="sidebar-title">Idiomas</div>

                        @foreach($resume->languages as $lang)
                            @php
                                $langName = $lang['name'] ?? null;
                                $langLevel = $lang['level'] ?? null;
                            @endphp

                            @if($langName)
                                <div class="lang-row">
                                    <div class="lang-name">
                                        {{ $langName }}
                                    </div>

                                    <div class="lang-level">
                                        {{ $langLevel ?? '' }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if(!empty($resume->certifications) && is_array($resume->certifications))
                    <div class="sidebar-block">
                        <div class="sidebar-title">Certificaciones</div>

                        @foreach($resume->certifications as $cert)
                            @php
                                $certName = $cert['name'] ?? null;
                                $institution = $cert['institution'] ?? null;
                                $year = $cert['year'] ?? null;
                            @endphp

                            @if($certName)
                                <div class="cert-item">
                                    <div class="cert-name">
                                        {{ $certName }}
                                    </div>

                                    <div class="cert-meta">
                                        @if($institution)
                                            {{ $institution }}
                                        @endif

                                        @if($year)
                                            @if($institution)
                                                ·
                                            @endif

                                            {{ $year }}
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- CONTENT -->
            <div class="content">
                <div class="main-header">
                    <div class="header-accent"></div>

                    <div class="page-name">
                        {{ $candidate->user->name }}
                    </div>

                    <!--<div class="page-subtitle">
                        Currículum profesional
                    </div>

                    <div class="top-meta">
                        Documento generado el {{ now()->format('d/m/Y') }}
                    </div>-->
                </div>

                @if(!empty($resume->summary))
                    <div class="section">
                        <div class="section-title-wrap">
                            <div class="section-title">Resumen profesional</div>
                            <!--<div class="section-marker">MW</div>-->
                        </div>

                        <div class="summary">
                            {{ $resume->summary }}
                        </div>
                    </div>
                @endif

                @if(!empty($resume->work_experience) && is_array($resume->work_experience))
                    <div class="section">
                        <div class="section-title-wrap">
                            <div class="section-title">Experiencia laboral</div>
                            <!--<div class="section-marker">01</div>-->
                        </div>

                        @foreach($resume->work_experience as $exp)
                            @php
                                $position = $exp['position'] ?? null;
                                $company = $exp['company'] ?? null;
                                $start = $exp['start_date'] ?? null;
                                $end = $exp['end_date'] ?? null;
                                $description = $exp['description'] ?? null;

                                $startFmt = $start ? \Carbon\Carbon::parse($start)->translatedFormat('M Y') : null;
                                $endFmt = $end ? \Carbon\Carbon::parse($end)->translatedFormat('M Y') : 'Actualidad';
                            @endphp

                            @if($position || $company)
                                <div class="entry">
                                    <div class="entry-top">
                                        <div class="entry-main">
                                            <div class="entry-title">
                                                {{ $position ?? '—' }}
                                            </div>

                                            @if($company)
                                                <div class="entry-subtitle">
                                                    {{ $company }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="entry-meta">
                                            @if($startFmt)
                                                <div class="entry-date">
                                                    {{ $startFmt }} — {{ $endFmt }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    @if(!empty($description))
                                        <div class="entry-desc">
                                            {{ $description }}
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                @if(!empty($resume->education) && is_array($resume->education))
                    <div class="section">
                        <div class="section-title-wrap">
                            <div class="section-title">Educación</div>
                            <!-- <div class="section-marker">02</div> -->
                        </div>

                        @foreach($resume->education as $edu)
                            @php
                                $title = $edu['title'] ?? null;
                                $school = $edu['school'] ?? null;
                                $year = $edu['year'] ?? null;
                            @endphp

                            @if($title || $school || $year)
                                <div class="entry">
                                    <div class="entry-top">
                                        <div class="entry-main">
                                            <div class="entry-title">
                                                {{ $title ?? '—' }}
                                            </div>

                                            @if($school)
                                                <div class="entry-subtitle">
                                                    {{ $school }}
                                                </div>
                                            @endif
                                        </div>

                                        <div class="entry-meta">
                                            @if($year)
                                                <div class="entry-date">
                                                    {{ $year }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <!--<div class="footer">
            Empleo Mister Wings · Página <span class="page-number"></span> de <span class="page-count"></span>
        </div>-->
    </div>
</body>

</html>