@extends('layouts.mail')

@section('content')
    <div style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; display: none;">
        {{ $result['type'] == 'verify' ? 'Verify your Email!' : 'Reset Password' }}
    </div>
    <div role="article" aria-roledescription="email" aria-label="Notifikasi Deposit" lang="en"
        style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
        <table style="width: 100%; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;" cellpadding="0"
            cellspacing="0" role="presentation">
            <tr>
                <td align="center"
                    style="mso-line-height-rule: exactly; background-color: #eceff1; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
                    <table class="sm-w-full" style="width: 600px;" cellpadding="0" cellspacing="0" role="presentation">
                        <tr>
                            <td class="sm-py-32 sm-px-24"
                                style="mso-line-height-rule: exactly; padding: 24px; text-align: center; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif;">
                                <a href="{{ route('auth.login.index') }}"
                                    style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                    <img src="{{ asset('assets/image/logo-2.png') }}" alt="Logo">
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td align="center"
                                style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly;">
                                <table style="width: 100%;" cellpadding="0" cellspacing="0" role="presentation">
                                    <tr>
                                        <td class="sm-px-24"
                                            style="mso-line-height-rule: exactly; border-radius: 4px; background-color: #ffffff; padding: 24px; text-align: left; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 16px; line-height: 24px; color: #626262;">
                                            <p
                                                style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-bottom: 0; font-size: 16px; font-weight: 600;">
                                                Hi,</p>
                                            <p
                                                style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; margin-top: 0; font-size: 16px; font-weight: 700; color: #0099ff;">
                                                {{ $result['email'] }}</p>
                                            @if ($result['type'] == 'verify')
                                                <p
                                                    style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                                                    Please verify the unique code below to continue the registration
                                                    process. This code is valid until {{ $result['expired_at'] }} WIB.
                                                </p>
                                            @else
                                                <p
                                                    style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                                                    Please use the unique code below to reset your password. This code is
                                                    valid until {{ $result['expired_at'] }} WIB.
                                                </p>
                                            @endif
                                            <hr style="border-top:dashed 1px">
                                            <b
                                                style="text-align: center; font-family: 'Montserrat', sans-serif; font-size: 16px; mso-line-height-rule: exactly; margin: 0;">
                                                {{ $result['token'] }}
                                            </b>
                                            <hr style="border-top:dashed 1px">
                                            <p
                                                style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                                                Thank you for placing your trust in us. If you did not initiate this
                                                @if ($result['type'] == 'verify')
                                                    registration
                                                @else
                                                    password reset
                                                @endif
                                                request, please disregard this email.
                                            </p>
                                            <p
                                                style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                                                From, <br
                                                    style="text-transform: uppercase;"><b>{{ config('app.name') }}.</b>
                                            </p>
                                            <hr style="border-top:dashed 1px">
                                            <p
                                                style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; margin: 0; margin-bottom: 8px;">
                                                Website : <a href="{{ route('home') }}">{{ route('home') }}</a>
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; height: 8px;">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="mso-line-height-rule: exactly; font-size: 12px; font-family: Montserrat, -apple-system, 'Segoe UI', sans-serif; font-size: 12px; color: #eceff1;">
                                            <p class="sm-px-24"
                                                style="font-family: 'Montserrat', sans-serif; font-size: 12px; mso-line-height-rule: exactly; color: #263238;">
                                                The use of our services and website is subject to our
                                                <a href="{{ route('page.index', ['slug' => 'terms-and-conditions']) }}" class="hover-underline"
                                                    style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; color: #0099ff; text-decoration: none;">
                                                    Terms & Conditions
                                                </a>. Thank you.
                                            </p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            style="font-family: 'Montserrat', sans-serif; mso-line-height-rule: exactly; height: 16px;">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
@endsection
