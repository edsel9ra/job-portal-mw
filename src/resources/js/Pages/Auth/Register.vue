<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const showPassword = ref(false);
const showPasswordConfirmation = ref(false);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role_type: 'candidato',
});

const passwordsMatch = computed(() => {
    return (
        form.password.length > 0 &&
        form.password_confirmation.length > 0 &&
        form.password === form.password_confirmation
    );
});

const passwordsDoNotMatch = computed(() => {
    return (
        form.password.length > 0 &&
        form.password_confirmation.length > 0 &&
        form.password !== form.password_confirmation
    );
});

const submit = () => {
    form.post(route('register'), {
        preserveScroll: true,
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout variant="modern">

        <Head title="Registro de cuenta" />

        <div
            class="relative flex min-h-screen w-full items-center justify-center overflow-hidden bg-slate-950 px-4 py-8 sm:px-6 lg:px-8">
            <!-- Fondos decorativos -->
            <div class="absolute left-[-120px] top-[-120px] h-80 w-80 rounded-full bg-red-600/30 blur-3xl"></div>

            <div class="absolute bottom-[-120px] right-[-120px] h-96 w-96 rounded-full bg-blue-700/30 blur-3xl"></div>

            <div class="absolute right-1/4 top-20 h-40 w-40 rounded-full bg-red-500/10 blur-2xl"></div>

            <div
                class="relative grid w-full max-w-6xl overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 shadow-2xl shadow-black/40 backdrop-blur-xl lg:grid-cols-[1.05fr_0.95fr]">
                <!-- Panel izquierdo -->
                <section
                    class="relative hidden overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <div class="absolute -right-20 top-16 h-56 w-56 rounded-full bg-red-600/20 blur-3xl"></div>

                    <div class="absolute bottom-10 left-10 h-40 w-40 rounded-full bg-blue-600/20 blur-2xl"></div>

                    <div class="relative">
                        <!-- Logo -->
                        <div class="mb-8 flex h-20 w-30 items-center justify-center">
                            <img src="/images/logo.png" alt="Logo de la empresa" class="h-30 w-30 object-contain" />
                        </div>
                        <h1 class="mt-6 max-w-md text-4xl font-black leading-tight tracking-tight">
                            Regístrate y accede al portal de empleo.
                        </h1>
                        <p class="mt-5 max-w-sm text-sm leading-7 text-slate-300">
                            Crea tu cuenta para postularte, consultar tus procesos y mantener actualizada tu
                            información.
                        </p>
                    </div>
                </section>

                <!-- Formulario -->
                <section class="bg-white px-6 py-8 sm:px-10 lg:px-12 lg:py-12">
                    <div class="mx-auto flex min-h-[620px] w-full max-w-md flex-col justify-center">
                        <div class="mb-8">
                            <!-- Logo móvil -->
                            <p class="text-sm font-bold uppercase tracking-[0.25em] text-red-600">
                                Registro
                            </p>

                            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">
                                Crear cuenta
                            </h2>

                            <p class="mt-3 text-sm leading-6 text-slate-500">
                                Completa tus datos para ingresar al portal.
                            </p>
                        </div>

                        <form class="space-y-5" @submit.prevent="submit">
                            <!-- Nombre -->
                            <div>
                                <InputLabel for="name" value="Nombre completo"
                                    class="text-sm font-bold text-slate-800" />

                                <div class="relative mt-2">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" stroke="currentColor"
                                                stroke-width="1.8" />
                                            <path d="M4.5 20a7.5 7.5 0 0 1 15 0" stroke="currentColor"
                                                stroke-width="1.8" stroke-linecap="round" />
                                        </svg>
                                    </div>

                                    <TextInput id="name" v-model="form.name" type="text"
                                        class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm shadow-sm transition duration-200 placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                                        required autofocus autocomplete="name"
                                        placeholder="Ingresa tu nombre completo" />
                                </div>

                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <!-- Email -->
                            <div>
                                <InputLabel for="email" value="Correo electrónico"
                                    class="text-sm font-bold text-slate-800" />

                                <div class="relative mt-2">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                            <path
                                                d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11Z"
                                                stroke="currentColor" stroke-width="1.8" />
                                            <path d="m6.5 8 5.5 4 5.5-4" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>

                                    <TextInput id="email" v-model="form.email" type="email"
                                        class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-4 text-sm shadow-sm transition duration-200 placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                                        required autocomplete="username" placeholder="ejemplo@correo.com" />
                                </div>

                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <!-- Password -->
                            <div>
                                <InputLabel for="password" value="Contraseña"
                                    class="text-sm font-bold text-slate-800" />

                                <div class="relative mt-2">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                            <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" />
                                            <path
                                                d="M6.5 11h11A1.5 1.5 0 0 1 19 12.5v6A1.5 1.5 0 0 1 17.5 20h-11A1.5 1.5 0 0 1 5 18.5v-6A1.5 1.5 0 0 1 6.5 11Z"
                                                stroke="currentColor" stroke-width="1.8" />
                                        </svg>
                                    </div>

                                    <TextInput id="password" v-model="form.password"
                                        :type="showPassword ? 'text' : 'password'"
                                        class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-24 text-sm shadow-sm transition duration-200 placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                                        required autocomplete="new-password" placeholder="Crea una contraseña" />

                                    <button type="button"
                                        class="absolute inset-y-0 right-4 flex items-center text-xs font-black uppercase tracking-wide text-red-600 transition hover:text-red-700"
                                        @click="showPassword = !showPassword">
                                        {{ showPassword ? 'Ocultar' : 'Mostrar' }}
                                    </button>
                                </div>

                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Confirmar password -->
                            <div>
                                <InputLabel for="password_confirmation" value="Confirmar contraseña"
                                    class="text-sm font-bold text-slate-800" />

                                <div class="relative mt-2">
                                    <div
                                        class="pointer-events-none absolute inset-y-0 left-4 flex items-center text-slate-400">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                            <path d="M7 11V8a5 5 0 0 1 10 0v3" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" />
                                            <path
                                                d="M6.5 11h11A1.5 1.5 0 0 1 19 12.5v6A1.5 1.5 0 0 1 17.5 20h-11A1.5 1.5 0 0 1 5 18.5v-6A1.5 1.5 0 0 1 6.5 11Z"
                                                stroke="currentColor" stroke-width="1.8" />
                                        </svg>
                                    </div>

                                    <TextInput id="password_confirmation" v-model="form.password_confirmation"
                                        :type="showPasswordConfirmation ? 'text' : 'password'"
                                        class="block w-full rounded-2xl border-slate-200 bg-slate-50 py-3 pl-12 pr-24 text-sm shadow-sm transition duration-200 placeholder:text-slate-400 focus:border-red-500 focus:bg-white focus:ring-red-500"
                                        required autocomplete="new-password" placeholder="Confirma tu contraseña" />

                                    <button type="button"
                                        class="absolute inset-y-0 right-4 flex items-center text-xs font-black uppercase tracking-wide text-red-600 transition hover:text-red-700"
                                        @click="showPasswordConfirmation = !showPasswordConfirmation">
                                        {{ showPasswordConfirmation ? 'Ocultar' : 'Mostrar' }}
                                    </button>
                                </div>

                                <div v-if="passwordsMatch"
                                    class="mt-2 rounded-xl border border-green-200 bg-green-50 px-3 py-2 text-xs font-semibold text-green-700">
                                    Las contraseñas coinciden.
                                </div>

                                <div v-if="passwordsDoNotMatch"
                                    class="mt-2 rounded-xl border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700">
                                    Las contraseñas no coinciden.
                                </div>

                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>

                            <!-- Campo oculto del rol -->
                            <input type="hidden" v-model="form.role_type" />

                            <!-- Botón -->
                            <button type="submit"
                                class="group relative flex w-full items-center justify-center overflow-hidden rounded-2xl bg-red-600 px-5 py-3.5 text-sm font-black text-white shadow-xl shadow-red-600/30 transition duration-300 hover:-translate-y-0.5 hover:bg-red-700 hover:shadow-red-700/40 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60 disabled:hover:translate-y-0"
                                :disabled="form.processing">
                                <span
                                    class="absolute inset-0 translate-x-[-100%] bg-gradient-to-r from-transparent via-white/20 to-transparent transition duration-700 group-hover:translate-x-[100%]"></span>

                                <svg v-if="form.processing" class="mr-2 h-4 w-4 animate-spin" viewBox="0 0 24 24"
                                    fill="none">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4" />

                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                                </svg>

                                <span class="relative">
                                    {{ form.processing ? 'Registrando...' : 'Crear cuenta' }}
                                </span>
                            </button>
                        </form>

                        <div class="mt-6 text-center">
                            <Link :href="route('login')"
                                class="text-sm font-bold text-slate-700 transition hover:text-red-600 hover:underline">
                                ¿Ya tienes una cuenta? Inicia sesión
                            </Link>
                        </div>

                        <!--<div class="mt-8 border-t border-slate-100 pt-5">
                            <p class="text-center text-xs font-medium text-slate-400">
                                Tu cuenta será creada con perfil de candidato.
                            </p>
                        </div>-->
                    </div>
                </section>
            </div>
        </div>
    </GuestLayout>
</template>