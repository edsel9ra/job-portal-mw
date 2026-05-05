<script setup>
import { ref, computed } from 'vue';
import { Link, usePage, Head } from '@inertiajs/vue3';

const sidebarOpen = ref(false);
const page = usePage();

const user = computed(() => page.props.auth?.user ?? null);

const userInitials = computed(() => {
    const name = user.value?.name ?? '';

    return name
        .split(' ')
        .filter(Boolean)
        .map((word) => word[0])
        .slice(0, 2)
        .join('')
        .toUpperCase();
});

function isActive(href) {
    try {
        return page.url.startsWith(new URL(href, window.location.origin).pathname);
    } catch {
        return false;
    }
}
</script>

<template>

    <Head title="Empleos Disponibles" />

    <div class="relative flex h-screen overflow-hidden bg-slate-100">
        <!-- Fondo decorativo general -->
        <div
            class="pointer-events-none absolute left-[-180px] top-[-180px] h-96 w-96 rounded-full bg-red-600/20 blur-3xl">
        </div>
        <div
            class="pointer-events-none absolute bottom-[-220px] right-[-220px] h-[32rem] w-[32rem] rounded-full bg-blue-700/20 blur-3xl">
        </div>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col overflow-hidden border-r border-white/10 bg-slate-950 text-white shadow-2xl shadow-black/40 transition-transform duration-300 ease-in-out lg:relative lg:translate-x-0 lg:h-full lg:flex-shrink-0">
            <!-- Decoración sidebar -->
            <div class="pointer-events-none absolute -right-24 top-16 h-56 w-56 rounded-full bg-red-600/20 blur-3xl">
            </div>
            <div class="pointer-events-none absolute bottom-10 left-8 h-40 w-40 rounded-full bg-blue-600/20 blur-2xl">
            </div>

            <!-- Logo -->
            <div class="relative flex h-20 flex-shrink-0 items-center border-b border-white/10 px-5">
                <Link href="/" class="flex min-w-0 items-center gap-3">
                    <div
                        class="flex h-12 w-12 flex-shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white/10 shadow-lg ring-1 ring-white/15">
                        <img src="/images/logo.png" alt="Mister Wings" class="h-9 w-9 object-contain" />
                    </div>

                    <div class="min-w-0">
                        <p class="truncate text-lg font-black uppercase tracking-wide text-white">
                            Empleo
                        </p>
                        <p class="truncate text-sm font-semibold text-slate-400">
                            Mister Wings
                        </p>
                    </div>
                </Link>
            </div>

            <!-- Usuario autenticado -->
            <!--<div v-if="user" class="relative flex-shrink-0 border-b border-white/10 px-4 py-4">
                <div class="rounded-3xl bg-white/10 p-4 shadow-lg ring-1 ring-white/10 backdrop-blur">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-2xl bg-red-600 text-sm font-black text-white shadow-lg shadow-red-900/30">
                            {{ userInitials }}
                        </div>

                        <div class="min-w-0">
                            <p class="truncate text-sm font-bold text-white">
                                {{ user.name }}
                            </p>

                            <p class="mt-0.5 text-xs font-medium text-slate-300">
                                {{ user.isReclutador ? 'Reclutador' : 'Candidato' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>-->

            <!-- Usuario sin sesión -->
            <!--<div v-else class="relative flex-shrink-0 border-b border-white/10 px-4 py-4">
                <div class="rounded-3xl bg-white/10 p-4 ring-1 ring-white/10">
                    <p class="text-xs font-semibold uppercase tracking-[0.18em] text-red-300">
                        Acceso rápido
                    </p>

                    <p class="mt-2 text-sm text-slate-300">
                        Ingresa o crea tu cuenta para postularte.
                    </p>

                    <div class="mt-4 grid grid-cols-2 gap-2">
                        <Link :href="route('login')"
                            class="rounded-2xl border border-white/10 px-3 py-2 text-center text-xs font-bold text-white transition hover:bg-white/10">
                            Iniciar
                        </Link>

                        <Link :href="route('register')"
                            class="rounded-2xl bg-red-600 px-3 py-2 text-center text-xs font-black text-white shadow-lg shadow-red-900/30 transition hover:bg-red-700">
                            Registrarse
                        </Link>
                    </div>
                </div>
            </div>-->

            <!-- Navegación -->
            <nav class="relative flex-1 overflow-y-auto px-4 py-5">
                <!--<p class="px-3 pb-2 text-sm font-black uppercase tracking-[0.22em] text-slate-500">
                    Empleos
                </p>-->

                <Link :href="route('jobs.index')"
                    class="group flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold transition" :class="isActive(route('jobs.index'))
                        ? 'bg-red-600 text-white shadow-lg shadow-red-950/30'
                        : 'text-slate-300 hover:bg-white/10 hover:text-white'" @click="sidebarOpen = false">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl transition" :class="isActive(route('jobs.index'))
                        ? 'bg-white/15'
                        : 'bg-white/10 group-hover:bg-white/15'">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M10.5 18a7.5 7.5 0 1 1 5.303-2.197L20 20" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" />
                        </svg>
                    </span>

                    <span>Ver ofertas</span>
                </Link>

                <template v-if="user">
                    <!--<p class="px-3 pb-2 pt-7 text-xs font-black uppercase tracking-[0.22em] text-slate-500">
                        Mi cuenta
                    </p>-->

                    <Link v-if="user.isReclutador" :href="route('reclutador.dashboard')"
                        class="group flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold text-slate-300 transition hover:bg-white/10 hover:text-white"
                        @click="sidebarOpen = false">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 transition group-hover:bg-white/15">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6h-4v6H5a1 1 0 0 1-1-1v-9.5Z"
                                    stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                            </svg>
                        </span>

                        <span>Mi dashboard</span>
                    </Link>

                    <Link v-else :href="route('candidato.dashboard')"
                        class="group flex items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold text-slate-300 transition hover:bg-white/10 hover:text-white"
                        @click="sidebarOpen = false">
                        <span
                            class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10 transition group-hover:bg-white/15">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                                <path d="M4 10.5 12 4l8 6.5V20a1 1 0 0 1-1 1h-5v-6h-4v6H5a1 1 0 0 1-1-1v-9.5Z"
                                    stroke="currentColor" stroke-width="1.8" stroke-linejoin="round" />
                            </svg>
                        </span>

                        <span>Mi dashboard</span>
                    </Link>
                </template>
            </nav>

            <!-- Footer sidebar -->
            <div class="relative flex-shrink-0 border-t border-white/10 px-4 py-4">
                <Link v-if="user" :href="route('logout')" method="post" as="button"
                    class="flex w-full items-center gap-3 rounded-2xl px-3 py-3 text-sm font-bold text-slate-300 transition hover:bg-red-600/15 hover:text-red-300">
                    <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-white/10">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none">
                            <path d="M15 17l5-5-5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M20 12H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" />
                            <path d="M12 20H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h6" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" />
                        </svg>
                    </span>

                    <span>Cerrar sesión</span>
                </Link>

                <p v-else class="px-2 text-center text-xs leading-5 text-slate-500">
                    © {{ new Date().getFullYear() }} Empleo Mister Wings.
                    <br />
                    Todos los derechos reservados.
                </p>
            </div>
        </aside>

        <!-- Overlay móvil -->
        <div v-if="sidebarOpen" class="fixed inset-0 z-40 bg-slate-950/70 backdrop-blur-sm lg:hidden"
            @click="sidebarOpen = false" />

        <!-- Área principal -->
        <div class="relative flex h-full min-w-0 flex-1 flex-col overflow-hidden">
            <!-- Topbar -->
            <header
                class="flex h-20 flex-shrink-0 items-center gap-4 border-b border-slate-200/80 bg-white/90 px-4 shadow-sm backdrop-blur-xl sm:px-6">
                <!-- Botón hamburguesa -->
                <button
                    class="flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600 lg:hidden"
                    type="button" @click="sidebarOpen = !sidebarOpen">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Header slot -->
                <div class="min-w-0 flex-1">
                    <slot name="header">
                        <div>
                            <!--<p class="text-xs font-black uppercase tracking-[0.22em] text-red-600">
                                Portal de empleo
                            </p>-->
                            <h1 class="mt-1 truncate text-xl font-black uppercase tracking-tight text-slate-950">
                                Portal de Empleo Mister Wings
                            </h1>
                        </div>
                    </slot>
                </div>

                <!-- Acciones derecha -->
                <div class="hidden items-center gap-3 sm:flex">
                    <div v-if="user"
                        class="flex items-center gap-3 rounded-2xl border border-slate-200 bg-white px-3 py-2 shadow-sm">
                        <div
                            class="flex h-8 w-9 items-center justify-center rounded-xl bg-slate-950 text-xs font-black text-white">
                            {{ userInitials }}
                        </div>

                        <div class="hidden min-w-0 md:block">
                            <p class="max-w-36 truncate text-sm font-bold text-slate-800">
                                {{ user.name }}
                            </p>
                            <p class="text-xs font-medium text-slate-400">
                                {{ user.isReclutador ? 'Reclutador' : 'Candidato' }}
                            </p>
                        </div>
                    </div>

                    <div v-else class="flex items-center gap-2">
                        <Link :href="route('login')"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-bold text-slate-700 shadow-sm transition hover:border-red-200 hover:bg-red-50 hover:text-red-600">
                            Iniciar sesión
                        </Link>

                        <Link :href="route('register')"
                            class="rounded-2xl bg-red-600 px-4 py-2.5 text-sm font-black text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700">
                            Registrarse
                        </Link>
                    </div>
                </div>
            </header>

            <!-- Contenido -->
            <main class="flex-1 overflow-y-auto bg-slate-100">
                <div class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot />
                </div>
            </main>
        </div>
    </div>
</template>
