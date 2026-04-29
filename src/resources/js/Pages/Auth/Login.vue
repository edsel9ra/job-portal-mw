<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const showPassword = ref(false);

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout variant="modern">

        <Head title="Iniciar sesión" />

        <div
            class="relative flex min-h-[720px] w-full items-center justify-center overflow-hidden rounded-[2rem] bg-slate-950 px-4 py-8 sm:px-6 lg:px-8">
            <!-- Fondos decorativos -->
            <div class="absolute left-[-120px] top-[-120px] h-80 w-80 rounded-full bg-red-600/30 blur-3xl"></div>
            <div class="absolute bottom-[-120px] right-[-120px] h-96 w-96 rounded-full bg-blue-700/30 blur-3xl"></div>
            <div class="absolute right-1/4 top-20 h-40 w-40 rounded-full bg-red-500/10 blur-2xl"></div>

            <div
                class="relative grid w-full max-w-5xl overflow-hidden rounded-[2rem] border border-white/10 bg-white/10 shadow-2xl shadow-black/40 backdrop-blur-xl lg:grid-cols-[1.05fr_0.95fr]">
                <!-- Panel izquierdo visual -->
                <section
                    class="relative hidden overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 p-10 text-white lg:flex lg:flex-col lg:justify-between">
                    <div class="absolute -right-20 top-16 h-56 w-56 rounded-full bg-red-600/20 blur-3xl"></div>
                    <div class="absolute bottom-10 left-10 h-40 w-40 rounded-full bg-blue-600/20 blur-2xl"></div>

                    <div class="relative">
                        <div class="mb-8 flex h-20 w-30 items-center justify-center">
                            <img src="/images/logo.png" alt="Logo de la empresa" class="h-30 w-30 object-contain" />
                        </div>
                        <h1 class="mt-6 max-w-md text-4xl font-black leading-tight tracking-tight">
                            Construyamos juntos el siguiente paso de tu carrera.
                        </h1>
                        <p class="mt-5 max-w-sm text-sm leading-7 text-slate-300">
                            Donde tus habilidades encuentran su propósito.
                        </p>
                    </div>

                    <div class="relative grid grid-cols-3 gap-3">
                        <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                            <p class="text-2xl font-black">24/7</p>
                            <p class="mt-1 text-xs text-slate-300">Acceso desde cualquier lugar.</p>
                        </div>

                        <div class="rounded-2xl bg-white/10 p-4 ring-1 ring-white/10">
                            <p class="text-2xl font-black">+</p>
                            <p class="mt-1 text-xs text-slate-300">Filtros inteligentes de búsqueda</p>
                        </div>

                        <div class="rounded-2xl bg-red-600 p-4 shadow-lg shadow-red-900/40">
                            <p class="text-2xl font-black">Go</p>
                            <p class="mt-1 text-xs text-red-100">Empieza ahora mismo</p>
                        </div>
                    </div>
                </section>

                <!-- Formulario -->
                <section class="bg-white px-6 py-8 sm:px-10 lg:px-12 lg:py-12">
                    <div class="mx-auto w-full max-w-md">
                        <div class="mb-8">
                            <p class="text-sm font-bold uppercase tracking-[0.25em] text-red-600">
                                Bienvenido al Portal de Empleo Mister Wings
                            </p>

                            <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">
                                Gestión de talento simplificada.
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Ingresa tus credenciales para continuar.
                            </p>
                        </div>
                        <div v-if="status"
                            class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-semibold text-green-700">
                            {{ status }}
                        </div>

                        <form class="space-y-5" @submit.prevent="submit">
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
                                        required autofocus autocomplete="username" placeholder="ejemplo@correo.com" />
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
                                        required autocomplete="current-password" placeholder="Ingresa tu contraseña" />

                                    <button type="button"
                                        class="absolute inset-y-0 right-4 flex items-center text-xs font-black uppercase tracking-wide text-red-600 transition hover:text-red-700"
                                        @click="showPassword = !showPassword">
                                        {{ showPassword ? 'Ocultar' : 'Mostrar' }}
                                    </button>
                                </div>

                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <!-- Opciones -->
                            <div class="flex flex-col gap-3 pt-1 sm:flex-row sm:items-center sm:justify-between">
                                <!--<label class="flex cursor-pointer items-center">
                                    <Checkbox name="remember" v-model:checked="form.remember"
                                        class="rounded border-slate-300 text-red-600 shadow-sm focus:ring-red-500" />

                                    <span class="ms-2 text-sm font-medium text-slate-600">
                                        Recordarme
                                    </span>
                                </label>-->

                                <Link v-if="canResetPassword" :href="route('password.request')"
                                    class="text-sm font-bold text-slate-800 transition hover:text-red-600 hover:underline focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    ¿Olvidaste tu contraseña?
                                </Link>
                            </div>

                            <div>
                                <Link :href="route('register')"
                                    class="text-sm font-bold text-slate-800 transition hover:text-red-600 hover:underline focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                    ¿No tienes una cuenta? Regístrate aquí
                                </Link>
                            </div>

                            <!-- Botón -->
                            <button type="submit"
                                class="group relative mt-2 flex w-full items-center justify-center overflow-hidden rounded-2xl bg-red-600 px-5 py-3.5 text-sm font-black text-white shadow-xl shadow-red-600/30 transition duration-300 hover:-translate-y-0.5 hover:bg-red-700 hover:shadow-red-700/40 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-60 disabled:hover:translate-y-0"
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
                                    {{ form.processing ? 'Ingresando...' : 'Explorar vacantes' }}
                                </span>
                            </button>
                        </form>

                        <!--<div class="mt-8 border-t border-slate-100 pt-5">
                            <p class="text-center text-xs font-medium text-slate-400">
                                Acceso exclusivo para personal autorizado.
                            </p>
                        </div>-->
                    </div>
                </section>
            </div>
        </div>
    </GuestLayout>
</template>