<style>
  #nav-panel{
    -webkit-overflow-scrolling: touch;
  }
</style>

<?php
    $locale = session('locale', config('app.locale'));
    $homeRoute = $locale === 'es' ? 'homeEs' : 'homees';

    $languages = App\Models\Language::where('active', 1)->get();

    $campaigns = App\Models\Campaign::where('status', 'published')
        ->where('type', 'campaign')
        ->where('show_on_navbar', 1)
        ->orderByRaw('position IS NULL, position DESC')
        ->get();

    $supported = ['en', 'es'];

    $item = $campaign ?? $story ?? null;
    $segments = request()->segments();

    if (empty($segments)) {
        $pathForLanguage = 'home';
    } else {
        if (in_array($segments[0], $supported)) {
            array_shift($segments);
        }

        $pathForLanguage = !empty($segments) ? implode('/', $segments) : 'home';
    }

    $currentSlug = $item
        ? ($item->getTranslation('slug', $locale, false) ?: $item->getTranslation('slug', 'en', false))
        : $pathForLanguage;
?>

<header class="sticky top-0 z-[999]">
    <div class="">
        <div class="mx-auto max-w-7xl">

            
            <div class="flex items-center justify-end text-[11px] py-1 px-2
                border-b border-white/25 bg-[#D94647] md:bg-[#f04848] lg:bg-[#E6EDF5] border-l-[20px] border-l-[#f04848]">

                <span class="hidden mr-10 lg:block">
                    <strong class="text-[#674C4F]"><?php echo e(translate('Email')); ?></strong>
                    <a href="mailto:Donate@Sai.ngo" class="ml-1 font-semibold hover:underline text-[#D94647]">
                        <strong class="text-[#D94647]"><?php echo e($setting->email); ?></strong>
                    </a>
                </span>

                <span class="hidden mr-10 lg:block">
                    <strong class="text-[#674C4F]"><?php echo e(translate('Call Us')); ?></strong>
                    <span class="ml-1 font-semibold text-[#D94647]">
                        <strong class="text-[#D94647]"><?php echo e($setting->telephone); ?></strong>
                    </span>
                </span>

                <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $setting->whatsapp_number)); ?>?text=<?php echo e(urlencode('Hello, I want to know more details.')); ?>"
                   target="_blank"
                   class="font-semibold hover:underline text-[#674C4F] hidden lg:block">
                    <strong class="text-[#674C4F] underline">Whatsapp &gt;</strong>
                </a>

                <div class="hidden gap-1 ml-3 lg:flex">
                    <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <form action="<?php echo e(route('languageUpdateStatus', [
                            'language' => $language->id,
                            'campaign_slug' => $currentSlug
                        ])); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" title="<?php echo e($language->title); ?>" class="block rounded-sm">
                                <img src="<?php echo e(asset('storage/country_flag/'.$language->country_flag)); ?>"
                                     style="height:14px;width:20px;border-radius:1px;"
                                     alt="<?php echo e($language->title); ?>">
                            </button>
                        </form>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <style>
                @media (max-width: 768px) {
                    .logo-top {
                        padding-top: 25px;
                    }
                }
            </style>

            
            <div class="flex items-center justify-between px-2 bg-[#D94647]">
                
                <a href="<?php echo e(route($homeRoute)); ?>" class="logo-top">
                    <img src="<?php echo e(asset('images/logo/logo.png')); ?>"
                         alt="South American Initiative"
                         class="logo-img h-10 w-auto object-contain md:h-12 lg:h-14 pt-[27px] lg:pt-[9px]">
                </a>

                <nav class="hidden lg:flex lg:items-center text-[13px] font-semibold tracking-[0.03em]-">
                    
                    <a href="<?php echo e(route($homeRoute)); ?>"
                       class="flex items-center px-2 text-white h-14 uppercase">
                        <?php echo e(translate('Home')); ?>

                    </a>

                    
                    <a href="<?php echo e($locale === 'es' ? route('aboutUsEs') : route('aboutUs')); ?>"
                       class="flex items-center px-2 text-white h-14 uppercase">
                        <?php echo e(translate('About us')); ?>

                    </a>

                    
                    <div class="relative group">
                        <a href="<?php echo e($locale === 'en' ? route('campaigns') : route('campaignsEs')); ?>"
                           class="flex items-center gap-1 px-2 text-white uppercase h-14">
                            <span><?php echo e(translate('Campaign')); ?></span>
                            <span class="text-[10px] mt-[2px]">▼</span>
                        </a>

                        <div class="absolute left-0 top-full min-w-[250px] bg-white text-slate-800 text-[13px]
                            shadow-xl border border-slate-100 hidden group-hover:block z-40">

                            <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $campaignPath = $locale === 'es'
                                        ? ($item->getTranslation('path', 'es', false) ?: $item->getTranslation('path', 'en', false))
                                        : ($item->getTranslation('path', 'en', false) ?: $item->getTranslation('path', 'es', false));

                                    $campaignSlug = $locale === 'es'
                                        ? ($item->getTranslation('slug', 'es', false) ?: $item->getTranslation('slug', 'en', false))
                                        : ($item->getTranslation('slug', 'en', false) ?: $item->getTranslation('slug', 'es', false));

                                    $campaignPath = is_string($campaignPath) ? trim($campaignPath) : '';
                                    $campaignSlug = is_string($campaignSlug) ? trim($campaignSlug) : '';

                                    $campaignUrl = null;

                                    if ($campaignPath !== '' && $campaignSlug !== '') {
                                        $campaignUrl = $locale === 'es'
                                            ? route('campaignsdetailsEsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug])
                                            : route('campaignsdetailsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug]);
                                    }
                                ?>

                                <?php if($campaignUrl): ?>
                                    <a href="<?php echo e($campaignUrl); ?>"
                                       class="block px-4 py-2 border-b border-slate-100 hover:bg-red-50 hover:text-[#f04848] normal-case capitalize">
                                        <?php echo e($item->title); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>

                    
                    <a href="<?php echo e($locale === 'en' ? route('news') : route('newsEs')); ?>"
                       class="flex items-center px-2 text-white h-14 uppercase">
                        <?php echo e(translate('News')); ?>

                    </a>

                    
                    <div class="relative group">
                        <a href="#"
                           class="flex items-center gap-1 px-2 text-white uppercase h-14">
                            <span><?php echo e(translate('More Ways To Help')); ?></span>
                            <span class="text-[10px] mt-[2px]">▼</span>
                        </a>

                        <div class="absolute left-0 top-full min-w-[250px] bg-white text-slate-800 text-[13px]
                            shadow-xl border border-slate-100 hidden group-hover:block z-40">

                            <a href="<?php echo e($locale === 'en' ? route('doubleDonation') : route('doubleDonationEs')); ?>"
                               class="block px-4 py-2 border-b border-slate-100 hover:bg-red-50 hover:text-[#f04848] normal-case capitalize">
                                <?php echo e(translate('Employer matching and volunteering')); ?>

                            </a>

                            <a href="<?php echo e($locale === 'en' ? route('dafDonation') : route('dafDonationEs')); ?>"
                               class="block px-4 py-2 border-b border-slate-100 hover:bg-red-50 hover:text-[#f04848] normal-case capitalize">
                                <?php echo e(translate('Donor Advised Funds')); ?>

                            </a>

                            <a href="<?php echo e($locale === 'en' ? route('donateCripto') : route('donateCriptoEs')); ?>"
                               class="block px-4 py-2 border-b border-slate-100 hover:bg-red-50 hover:text-[#f04848] normal-case capitalize">
                                <?php echo e(translate('How to Donate Cryptocurrency ')); ?>

                            </a>
                        </div>
                    </div>

                    
                    <a href="<?php echo e($locale === 'en' ? route('contactUs') : route('contactUsEs')); ?>"
                       class="flex items-center px-2 text-white h-14 uppercase">
                        <?php echo e(translate('Contact us')); ?>

                    </a>

                    
                    <a href="<?php echo e($locale === 'en' ? route('donation') : route('donationEs')); ?>"
                       class="ml-4 bg-white text-[#f04848] text-[14px] font-extrabold uppercase px-7 py-2.5 rounded-sm shadow-sm flex items-center justify-center">
                        <?php echo e(translate('DONATE')); ?> &gt;
                    </a>
                </nav>

                
                <button id="nav-toggle"
                        class="p-2 text-2xl text-white lg:hidden relative z-[60]"
                        aria-label="Toggle menu">
                    <span id="icon-hamburger">☰</span>
                    <span id="icon-cross" class="hidden">✕</span>
                </button>
            </div>
        </div>
    </div>
</header>


<div id="nav-overlay"
     class="fixed inset-0 hidden bg-black/40 lg:hidden z-[900] pointer-events-none"></div>


<aside id="nav-panel"
       class="fixed top-0 bottom-0 right-0 w-72 max-w-full bg-[#D94647] text-white
         z-[950] transform translate-x-full transition-transform duration-300 ease-in-out lg:hidden
         pointer-events-auto h-screen overflow-y-auto overscroll-contain">

    <nav class="px-6 py-6 text-sm font-semibold tracking-[0.10em] uppercase space-y-4">
        <div class="pt-[90px]"></div>

        
        <a href="<?php echo e(route($homeRoute)); ?>" class="block text-[20px]">
            <?php echo e(translate('Home')); ?>

        </a>

        
        <a href="<?php echo e($locale === 'en' ? route('aboutUs') : route('aboutUsEs')); ?>" class="block text-xl">
            <?php echo e(translate('About us')); ?>

        </a>

        
        <div>
            <button type="button"
                    class="flex items-center justify-between w-full py-1 text-xl"
                    data-accordion="m-campaign">
                <span><?php echo e(translate('Campaign')); ?></span>
                <span class="text-xs" id="icon-m-campaign">▼</span>
            </button>

            <div id="panel-m-campaign"
                 class="pl-3 mt-1 space-y-1 text-[12px] tracking-normal leading-relaxed hidden">

                <?php $__currentLoopData = $campaigns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $campaignPath = $locale === 'es'
                            ? ($item->getTranslation('path', 'es', false) ?: $item->getTranslation('path', 'en', false))
                            : ($item->getTranslation('path', 'en', false) ?: $item->getTranslation('path', 'es', false));

                        $campaignSlug = $locale === 'es'
                            ? ($item->getTranslation('slug', 'es', false) ?: $item->getTranslation('slug', 'en', false))
                            : ($item->getTranslation('slug', 'en', false) ?: $item->getTranslation('slug', 'es', false));

                        $campaignPath = is_string($campaignPath) ? trim($campaignPath) : '';
                        $campaignSlug = is_string($campaignSlug) ? trim($campaignSlug) : '';

                        $campaignUrl = null;

                        if ($campaignPath !== '' && $campaignSlug !== '') {
                            $campaignUrl = $locale === 'es'
                                ? route('campaignsdetailsEsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug])
                                : route('campaignsdetailsDyn', ['path' => $campaignPath, 'slug' => $campaignSlug]);
                        }
                    ?>

                    <?php if($campaignUrl): ?>
                        <a href="<?php echo e($campaignUrl); ?>" class="block capitalize text-[18px]">
                            <?php echo e($item->title); ?>

                        </a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <a href="<?php echo e($locale === 'en' ? route('campaigns') : route('campaignsEs')); ?>" class="block font-semibold">
                    <?php echo e(translate('View All Campaigns')); ?>

                </a>
            </div>
        </div>

        
        <a href="<?php echo e($locale === 'en' ? route('news') : route('newsEs')); ?>" class="block text-xl">
            <?php echo e(translate('News')); ?>

        </a>

        
        <div>
            <button type="button"
                    class="flex items-center justify-between w-full py-1 text-xl"
                    data-accordion="m-help">
                <span><?php echo e(translate('More Ways To Help')); ?></span>
                <span class="text-xs" id="icon-m-help">▼</span>
            </button>

            <div id="panel-m-help"
                 class="pl-3 mt-1 space-y-1 text-[12px] tracking-normal leading-relaxed hidden">

                <a href="<?php echo e($locale === 'en' ? route('doubleDonation') : route('doubleDonationEs')); ?>"
                   class="block capitalize text-[18px]">
                    <?php echo e(translate('Employer matching and volunteering')); ?>

                </a>

                <a href="<?php echo e($locale === 'en' ? route('dafDonation') : route('dafDonationEs')); ?>"
                   class="block capitalize text-[18px]">
                    <?php echo e(translate('Donor Advised Funds')); ?>

                </a>

                <a href="<?php echo e($locale === 'en' ? route('donateCripto') : route('donateCriptoEs')); ?>"
                   class="block capitalize text-[18px]">
                    <?php echo e(translate('How to Donate Cryptocurrency ')); ?>

                </a>
            </div>
        </div>

        
        <a href="<?php echo e($locale === 'en' ? route('contactUs') : route('contactUsEs')); ?>" class="block text-xl">
            <?php echo e(translate('Contact us')); ?>

        </a>

        
        <a href="<?php echo e($locale === 'en' ? route('donation') : route('donationEs')); ?>"
           class="bg-white text-[#f04848] text-[14px] font-extrabold uppercase px-7 py-1 rounded-sm shadow-sm flex items-center justify-center">
            <?php echo e(translate('DONATE')); ?> &gt;
        </a>

        <div class="flex flex-wrap items-center gap-1">
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <form class="m-0" action="<?php echo e(route('languageUpdateStatus', [
                    'language' => $language->id,
                    'campaign_slug' => $currentSlug
                ])); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <button type="submit" title="<?php echo e($language->title); ?>" class="block rounded-sm">
                        <img src="<?php echo e(asset('storage/country_flag/'.$language->country_flag)); ?>"
                             class="h-[18px] w-[28px] rounded-[1px]"
                             alt="<?php echo e($language->title); ?>">
                    </button>
                </form>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="gap-1">
            <span><?php echo e(translate('Email')); ?> : <?php echo e($setting->email); ?></span> <br>
            <span><?php echo e(translate('Call Us')); ?>: <?php echo e($setting->telephone); ?></span>
        </div>
    </nav>
</aside>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const toggleBtn = document.getElementById('nav-toggle');
    const panel = document.getElementById('nav-panel');
    const overlay = document.getElementById('nav-overlay');

    if (!toggleBtn || !panel || !overlay) {
        console.log('Menu elements missing:', { toggleBtn, panel, overlay });
        return;
    }

    const iconHamburger = document.getElementById('icon-hamburger');
    const iconCross = document.getElementById('icon-cross');

    function setMenu(open) {
        if (open) {
            panel.classList.remove('translate-x-full');
            overlay.classList.remove('hidden');

            iconHamburger?.classList.add('hidden');
            iconCross?.classList.remove('hidden');

            document.documentElement.classList.add('overflow-hidden');
            document.body.classList.add('overflow-hidden');
        } else {
            panel.classList.add('translate-x-full');
            overlay.classList.add('hidden');

            iconHamburger?.classList.remove('hidden');
            iconCross?.classList.add('hidden');

            document.documentElement.classList.remove('overflow-hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    function isOpen() {
        return !panel.classList.contains('translate-x-full');
    }

    toggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        setMenu(!isOpen());
    });

    panel.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    overlay.addEventListener('click', function () {
        setMenu(false);
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            setMenu(false);
        }
    });

    setMenu(false);

    const buttons = document.querySelectorAll('[data-accordion^="m-"]');

    function closeAll(exceptKey = null) {
        buttons.forEach(btn => {
            const key = btn.getAttribute('data-accordion');
            if (exceptKey && key === exceptKey) return;

            const p = document.getElementById('panel-' + key);
            const i = document.getElementById('icon-' + key);

            p?.classList.add('hidden');
            if (i) i.textContent = '▼';
        });
    }

    buttons.forEach(btn => {
        const key = btn.getAttribute('data-accordion');
        const panelEl = document.getElementById('panel-' + key);
        const iconEl  = document.getElementById('icon-' + key);

        if (!panelEl) return;

        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();

            const willOpen = panelEl.classList.contains('hidden');

            closeAll(key);

            if (willOpen) {
                panelEl.classList.remove('hidden');
                if (iconEl) iconEl.textContent = '▲';
            } else {
                panelEl.classList.add('hidden');
                if (iconEl) iconEl.textContent = '▼';
            }
        });
    });

});
</script><?php /**PATH /home/saingo/public_html/resources/views/frontend/layouts/header.blade.php ENDPATH**/ ?>