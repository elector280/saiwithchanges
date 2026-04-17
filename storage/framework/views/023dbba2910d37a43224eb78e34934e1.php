


<footer class="bg-[#2b2b2b] text-[#d3d7e0] pt- text-[11px] sm:text-xs">
    <!-- ASK US floating button -->
      

    <button id="scrollToTop" class="fixed bottom-6 right-6 items-center justify-center w-12 h-12 rounded-full bg-[#D94647] text-white shadow-lg hover:bg-[#D94647] transition-all duration-300 flex" aria-label="Scroll to top">
        ↑
    </button> 

    <div class="relative max-w-7xl px-4 mx-auto md:py-5">
        <!-- CHAT BOX -->
        
        <div id="chatBox" class="fixed bottom-16 w-80 z-30 text-slate-800 text-[11px] hidden right-16 sm:right-[210px]">
        <div class="bg-white rounded-[12px] shadow-2xl border border-[#e95858] overflow-hidden">

            <div class="flex items-center justify-between bg-[#e95858] text-white px-4 py-2 text-[11px] font-semibold rounded-t-[12px]">
            <span> <?php echo e(translate('CHAT WITH US')); ?></span>
            <button class="text-xs leading-none chat-close" aria-label="Collapse chat">✕</button>
            </div>

            <div id="chatMessages" class="px-3 py-3 space-y-3 bg-white max-h-[320px] overflow-y-auto"></div>

            <div class="border-t border-slate-200">
            <div class="flex items-center bg-[#eaf1ff] px-2 py-2">
                <input id="chatInput" type="text" placeholder="Type something to start a chat"
                    class="flex-1 bg-transparent outline-none text-[11px] placeholder:text-slate-500" />
                <button id="chatSendBtn"
                        class="ml-2 w-6 h-6 rounded-full bg-[#2d6cdf] flex items-center justify-center text-white text-[11px]">
                ➤
                </button>
            </div>
            </div>

        </div>
        </div>


        
        <div class="lg:hidden">
            <div class="flex flex-col items-center text-center">
                <img src="<?php echo e(asset('images/logo/logo3.png')); ?>" class="h-[70px] w-auto object-contain mt-4"
                    alt="South American Initiative" />

                <div class="w-full mt-6">
                    <div class="h-px bg-white/20"></div>
                    <p class="mt-4 uppercase sm:text-xl text-white/70">
                        <?php echo e(translate('Our Certifications')); ?>

                    </p>
                    <?php 
                        $certifications = App\Models\Sponsor::where('type', 'certifications')->latest()->get();
                    ?>

                    <div class="flex flex-wrap items-center justify-center gap-4 mt-4">
                        <?php $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/company_logo/'.$item->company_logo)); ?>" alt="<?php echo e($item->company_name); ?>" title="<?php echo e($item->company_name); ?>" class="object-contain w-auto h-8" />
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>

            <div class="mt-10 grid grid-cols-3 gap-3 text-[11px]">
                <div>
                    <h3 class="font-semibold uppercase text-white/80"><?php echo e(translate('Website')); ?></h3>
                    <ul class="mt-3 space-y-2 text-white/70">
                        <li><a href="<?php echo e(route('homees')); ?>" class="hover:underline"> <?php echo e(translate('Home')); ?></a></li>
                        <li><a href="<?php echo e(route('aboutUs')); ?>" class="hover:underline"> <?php echo e(translate('About us')); ?></a></li>
                        <li><a href="<?php echo e(route('campaigns')); ?>" class="hover:underline"> <?php echo e(translate('Explore campaign')); ?></a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold uppercase text-white/80"> <?php echo e(translate('Contacts Info')); ?></h3>
                    <ul class="mt-3 space-y-2 text-white/70">
                        <li><?php echo e($setting->email); ?></li>
                        <li><?php echo e($setting->telephone); ?></li>
                        <li class="leading-relaxed">
                            <?php echo e($setting->address); ?>

                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="font-semibold uppercase text-white/80">Donations <?php echo e(translate('Donation')); ?></h3>
                    <ul class="mt-3 space-y-2 text-white/70">
                        <li><a href="<?php echo e(route('donation')); ?>" class="hover:underline"> <?php echo e(translate('Donate')); ?></a></li> 
                        <li><a href="<?php echo e(route('doubleDonation')); ?>" class="hover:underline"><?php echo e(translate('Double Donation')); ?></a></li>
                        <li><a href="<?php echo e(route('dafDonation')); ?>" class="hover:underline"> <?php echo e(translate('DAF Donation')); ?></a></li>
                    </ul>
                </div>
            </div>

            <p class="mt-10 text-[12px] leading-relaxed text-white/70">
                <?php if(!empty($setting->description)): ?>
                    <?php echo $setting->description; ?>

                <?php endif; ?>                
            </p>
        </div>

        
        <div class="hidden lg:grid gap-10 lg:grid-cols-[1.7fr,1.7fr]">
            <!-- LEFT SIDE -->
            <div class="text-left">
                <div class="flex flex-col md:flex-row md:items-center md:gap-10">
                    <div class="flex justify-center mb-4 md:justify-start md:mb-0">
                        <img src="<?php echo e(asset('images/logo/logo3.png')); ?>" class="h-[80px] w-auto object-contain"
                            alt="<?php echo e(translate('South American Initiative alt')); ?>"/>
                    </div>

                    <div class="flex flex-col items-center md:items-start">
                        <span class="mb-3 text-xl text-white uppercase"><?php echo e(translate('Our Certifications')); ?></span>

                        <div class="flex flex-wrap items-center gap-3">
                            <?php $__currentLoopData = $certifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <img src="<?php echo e(asset('storage/company_logo/'.$item->company_logo)); ?>" class="object-contain w-auto h-8" />
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <p class="mt-5 leading-relaxed max-w-md text-[14px] sm:text-[15px]">
                    <?php if(!empty($setting->description)): ?>
                        <?php echo $setting->description; ?>

                    <?php endif; ?>
                </p>
            </div>

            <!-- RIGHT SIDE -->
            <div class="lg:border-t lg:border-[#4b4b4b] lg:pt-4">
                <div class="grid gap-8 sm:grid-cols-[1.1fr,1.2fr,1.5fr]">

                    <!-- WEBSITE LINKS -->
                    <div>
                        <h3 class="font-semibold text-[#FE6668] text-[14px] uppercase"> <?php echo e(translate('Website')); ?></h3>
                        <ul class="mt-3">
                            <li class="mt-3"><a href="<?php echo e(route('homees')); ?>" class="hover:underline text-[15px]"> <?php echo e(translate('Home')); ?></a></li>
                            <li class="mt-3"><a href="<?php echo e(route('aboutUs')); ?>" class="hover:underline text-[15px]"><?php echo e(translate('About us ')); ?></a></li>
                            <li class="mt-3"><a href="<?php echo e(route('campaigns')); ?>" class="hover:underline text-[15px]"> <?php echo e(translate('Campaigns')); ?></a></li>
                        </ul>

                    </div>

                    <!-- EMAIL & PHONE -->
                    <div>
                        <h3 class="font-semibold text-[#FE6668] text-[11px] uppercase"> <?php echo e(translate('Email Address')); ?></h3>
                        <p class="mt-2 text-white"><?php echo e($setting->telephone); ?></p>

                        <h3 class="mt-4 font-semibold text-[#FE6668] text-[11px] uppercase mt-2"> <?php echo e(translate('Telephone')); ?></h3>
                        <p class="mt-1"><?php echo e($setting->email); ?></p>
                    </div>

                    <!-- ADDRESS + SOCIAL MEDIA CHANNELS -->
                    <div>
                        <h3 class="font-semibold text-[#FE6668] text-[11px] uppercase"> <?php echo e(translate('Address')); ?></h3>
                        <p class="mt-1 leading-relaxed whitespace-pre-line">
                            <?php if(!empty($setting->address)): ?>
                                <?php echo $setting->address; ?>

                            <?php endif; ?>
                        </p>

                        <!-- SOCIAL MEDIA CHANNELS + EMAIL FORM -->
                        <div class="mt-6">
                            <p class="text-[11px] font-semibold uppercase text-[#ff7f7f]">
                                 <?php echo e(translate('Subscribe To Newsletter')); ?>

                            </p>
                             
                           <form class="newsletterForm w-full max-w-xs mt-3" action="<?php echo e(route('newsletter.subscribe')); ?>" method="post">
                                <?php echo csrf_field(); ?>

                                <div class="flex items-center bg-white rounded-full overflow-hidden shadow-[0_2px_6px_rgba(0,0,0,0.25)]">
                                    <input type="email" name="email" placeholder="Insert Your best email"
                                        class="flex-1 px-3 py-2 text-[11px] text-slate-700 border-0 outline-none placeholder:text-slate-400" />

                                    <button type="submit"
                                            class="newsletterBtn px-5 py-2 text-[11px] font-semibold uppercase bg-[#ff6e6e] text-white whitespace-nowrap hover:bg-[#ff5959] transition">
                                        <?php echo e(translate('Send Email')); ?> &gt;
                                    </button>
                                </div>

                                <!-- ✅ response message per form -->
                                <p class="newsletterMsg mt-2 text-[11px]"></p>
                            </form>

                            <?php if(session('success')): ?>
                                <p
                                    class="mt-2 rounded-md
                                            px-4- py-0 text-sm text-emerald-300">
                                    <?php echo e(session('success')); ?>

                                </p>
                            <?php endif; ?>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p
                                    class="mt-2 rounded-md
                                            px-4- py-0 text-sm text-emerald-300">
                                    <?php echo e($message); ?>

                                </p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</footer>


<script>
    const scrollBtn = document.getElementById('scrollToTop');

    window.addEventListener('scroll', () => {
        if (window.scrollY > 200) {
            scrollBtn.classList.remove('hidden');
            scrollBtn.classList.add('flex');
        } else {
            scrollBtn.classList.add('hidden');
            scrollBtn.classList.remove('flex');
        }
    });

    scrollBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
</script>
<?php /**PATH /home/saingo/public_html/resources/views/frontend/layouts/footer.blade.php ENDPATH**/ ?>