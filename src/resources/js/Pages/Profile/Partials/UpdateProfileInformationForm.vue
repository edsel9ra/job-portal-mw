<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <section class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-sm">
        <div class="border-b border-slate-100 bg-slate-50 px-6 py-5">
            <div class="flex items-start gap-4">
                <div
                    class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-2xl bg-red-50 text-red-600">
                    <span class="material-symbols-outlined">person</span>
                </div>

                <div>
                    <p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                        Información de perfil
                    </p>

                    <h2 class="mt-2 text-xl font-black text-slate-950">
                        Datos de la cuenta
                    </h2>

                    <p class="mt-1 text-sm leading-6 text-slate-500">
                        Actualiza tu nombre y dirección de correo electrónico.
                    </p>
                </div>
            </div>
        </div>

        <form @submit.prevent="form.patch(route('profile.update'))" class="space-y-6 px-6 py-6">
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <InputLabel for="name" value="Nombre" class="text-sm font-black text-slate-800" />

                    <div class="relative mt-2">
                        <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">badge</span>
                        </div>

                        <TextInput id="name" v-model="form.name" type="text"
                            class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                            required autofocus autocomplete="name" />
                    </div>

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="email" value="Correo electrónico" class="text-sm font-black text-slate-800" />

                    <div class="relative mt-2">
                        <div class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                            <span class="material-symbols-outlined text-[18px]">mail</span>
                        </div>

                        <TextInput id="email" v-model="form.email" type="email"
                            class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm shadow-sm transition placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                            required autocomplete="username" />
                    </div>

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null"
                class="rounded-2xl border border-amber-200 bg-amber-50 px-4 py-4">
                <p class="text-sm leading-6 text-amber-800">
                    Tu dirección de correo electrónico no está verificada.

                    <Link :href="route('verification.send')" method="post" as="button"
                        class="font-black text-amber-900 underline transition hover:text-red-600">
                        Reenviar correo de verificación
                    </Link>
                </p>

                <div v-show="status === 'verification-link-sent'"
                    class="mt-3 rounded-xl border border-green-200 bg-green-50 px-3 py-2 text-sm font-semibold text-green-700">
                    Una nueva verificación ha sido enviada a tu dirección de correo electrónico.
                </div>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                    <p v-if="form.recentlySuccessful"
                        class="rounded-2xl border border-green-200 bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">
                        Guardado.
                    </p>
                </Transition>

                <PrimaryButton :disabled="form.processing"
                    class="!rounded-2xl !bg-red-600 !px-6 !py-3 !text-sm !font-black !text-white !shadow-lg !shadow-red-600/25 hover:!bg-red-700 disabled:!opacity-60">
                    {{ form.processing ? 'Guardando...' : 'Guardar cambios' }}
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>

<style scoped>
.material-symbols-outlined {
    font-variation-settings: "FILL" 0, "wght" 500, "GRAD" 0, "opsz" 24;
}
</style>