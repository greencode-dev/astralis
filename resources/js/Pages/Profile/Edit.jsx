import { Head } from '@inertiajs/react';
import DeleteUserForm from './Partials/DeleteUserForm';
import UpdatePasswordForm from './Partials/UpdatePasswordForm';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm';

export default function Edit({ mustVerifyEmail, status }) {
    return (
        <div className="min-h-screen" style={{ backgroundColor: '#0A0A1A' }}>
            <Head title="Profilo" />

            <div className="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
                {/* Header */}
                <div className="flex items-center justify-between mb-8">
                    <h1 className="text-2xl font-bold" style={{ color: '#F0F0FA' }}>Profilo</h1>
                    <a
                        href="/admin"
                        className="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                        style={{ backgroundColor: 'rgba(34, 211, 238, 0.15)', color: '#22D3EE' }}
                        onMouseEnter={e => { e.target.style.backgroundColor = 'rgba(34, 211, 238, 0.25)'; }}
                        onMouseLeave={e => { e.target.style.backgroundColor = 'rgba(34, 211, 238, 0.15)'; }}
                    >
                        <svg className="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Torna all'admin
                    </a>
                </div>

                <div className="space-y-6">
                    <div className="rounded-xl p-6 sm:p-8" style={{ backgroundColor: '#111128', border: '1px solid rgba(34, 211, 238, 0.1)' }}>
                        <UpdateProfileInformationForm
                            mustVerifyEmail={mustVerifyEmail}
                            status={status}
                            className="max-w-xl"
                        />
                    </div>

                    <div className="rounded-xl p-6 sm:p-8" style={{ backgroundColor: '#111128', border: '1px solid rgba(34, 211, 238, 0.1)' }}>
                        <UpdatePasswordForm className="max-w-xl" />
                    </div>

                    <div className="rounded-xl p-6 sm:p-8" style={{ backgroundColor: '#111128', border: '1px solid rgba(34, 211, 238, 0.1)' }}>
                        <DeleteUserForm className="max-w-xl" />
                    </div>
                </div>
            </div>
        </div>
    );
}
