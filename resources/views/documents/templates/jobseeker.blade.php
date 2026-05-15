<html>
<head>
    <style>
        body { font-family: 'Times New Roman', serif; font-size: 14px; color: #333; margin: 0; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px double #333; padding-bottom: 15px; }
        .header .republic { font-size: 12px; }
        .header .title { font-size: 20px; font-weight: bold; margin: 5px 0; }
        .header .subtitle { font-size: 14px; }
        .doc-title { text-align: center; font-size: 22px; font-weight: bold; margin: 30px 0 20px; text-decoration: underline; letter-spacing: 3px; }
        .content { line-height: 2; text-align: justify; padding: 0 20px; }
        .content p { text-indent: 40px; margin-bottom: 10px; }
        .resident-name { font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .signatory { margin-top: 60px; text-align: center; }
        .signatory .name { font-weight: bold; text-decoration: underline; text-transform: uppercase; }
        .signatory .position { font-size: 12px; }
        .footer-note { margin-top: 40px; font-size: 11px; color: #666; border-top: 1px solid #ccc; padding-top: 10px; }
        .control-no { position: absolute; top: 20px; right: 20px; font-size: 11px; color: #888; }
        .ra-box { border: 1px solid #333; padding: 10px 15px; margin: 20px 20px 0; font-size: 12px; background: #f9f9f9; }
        .oath { margin-top: 30px; padding: 0 20px; }
        .oath-line { margin-top: 30px; display: flex; justify-content: space-between; }
    </style>
</head>
<body>
    <div class="control-no">Control No: {{ $issuance->control_no }}</div>

    <div class="header">
        <div class="republic">Republic of the Philippines</div>
        <div class="subtitle">Province of {{ $province }}</div>
        <div class="subtitle">Municipality of {{ $municipality }}</div>
        <div class="title">BARANGAY {{ strtoupper($barangay) }}</div>
        <div class="subtitle">Office of the Punong Barangay</div>
    </div>

    <div class="doc-title">FIRST TIME JOB SEEKER CERTIFICATE</div>

    <div class="ra-box">
        <strong>Republic Act No. 11261</strong> — "An Act Providing for the Issuance of Free
        Certification for First Time Job Seekers in the Barangay, City or Municipal, and
        National Government Agencies and Instrumentalities"
    </div>

    <div class="content">
        <p><strong>TO WHOM IT MAY CONCERN:</strong></p>

        <p>This is to certify that <span class="resident-name">{{ $issuance->resident->full_name }}</span>,
        {{ $issuance->resident->age }} years old, {{ $issuance->resident->civil_status }},
        {{ $issuance->resident->nationality }}, and a bonafide resident of Barangay {{ $barangay }},
        {{ $municipality }}, {{ $province }}
        @if($issuance->resident->resident_since)
            since {{ \Carbon\Carbon::parse($issuance->resident->resident_since)->format('F Y') }}
        @endif
        , is a FIRST TIME JOB SEEKER and is qualified to avail the benefits under
        Republic Act No. 11261.</p>

        <p>This certification is being issued for <strong>{{ strtoupper($issuance->purpose) }}</strong>
        purposes and is valid for ONE (1) YEAR from the date of issuance.</p>

        <p>Issued this {{ \Carbon\Carbon::parse($issuance->issued_at)->format('jS') }} day of
        {{ \Carbon\Carbon::parse($issuance->issued_at)->format('F, Y') }} at Barangay {{ $barangay }},
        {{ $municipality }}, {{ $province }}.</p>
    </div>

    <div class="oath">
        <p style="font-size: 12px;"><strong>OATH OF UNDERTAKING:</strong></p>
        <p style="font-size: 11px; text-indent: 40px;">I, the undersigned, do hereby declare under penalty
        of perjury that the foregoing information is true and correct. I further undertake to inform
        the Barangay upon my employment.</p>

        <div class="oath-line">
            <div style="text-align: center; width: 45%;">
                <div style="border-top: 1px solid #333; padding-top: 5px; margin-top: 40px;">
                    Signature of Applicant
                </div>
            </div>
            <div style="text-align: center; width: 45%;">
                <div style="border-top: 1px solid #333; padding-top: 5px; margin-top: 40px;">
                    Date
                </div>
            </div>
        </div>
    </div>

    <div class="signatory">
        <div class="name">{{ $captain }}</div>
        <div class="position">Punong Barangay</div>
    </div>

    <div class="footer-note">
        <strong>Date Issued:</strong> {{ \Carbon\Carbon::parse($issuance->issued_at)->format('M d, Y') }}
        &nbsp;&nbsp; <em>(This certificate is issued FREE of charge per RA 11261.)</em>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
