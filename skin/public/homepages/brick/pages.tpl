{homepages_data}
{*<pre>{$hps|print_r}</pre>*}
{if isset($hps) && $hps != null}
    <section id="homepages" class="clearfix">
        <div class="container section-block">
            <div class="vignette-list">
                <p class="h2">{#popular_pages#|ucfirst}</p>
                <div class="row row-center">
                    {include file="homepages/loop/item.tpl" data=$hps classCol='vignette col-12 col-sm-6 col-md-4 col-xl-3'}
                </div>
            </div>
        </div>
    </section>
{/if}