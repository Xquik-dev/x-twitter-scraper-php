<?php

// SPDX-FileCopyrightText: 2026 Xquik contributors
//
// SPDX-License-Identifier: Apache-2.0

declare(strict_types=1);

namespace XTwitterScraper\ShadowbanReport;

use XTwitterScraper\Core\Attributes\Required;
use XTwitterScraper\Core\Concerns\SdkModel;
use XTwitterScraper\Core\Contracts\BaseModel;
use XTwitterScraper\ShadowbanReport\Checks\Account;
use XTwitterScraper\ShadowbanReport\Checks\Engagement;
use XTwitterScraper\ShadowbanReport\Checks\Replies;
use XTwitterScraper\ShadowbanReport\Checks\ReplyLock;
use XTwitterScraper\ShadowbanReport\Checks\Search;
use XTwitterScraper\ShadowbanReport\Checks\Sensitive;
use XTwitterScraper\ShadowbanReport\Checks\Suggestion;
use XTwitterScraper\ShadowbanReport\Checks\Timeline;
use XTwitterScraper\ShadowbanReport\Checks\Withheld;

/**
 * @phpstan-type ChecksShape = array{
 *   account: \XTwitterScraper\ShadowbanReport\Checks\Account|array<string,mixed>,
 *   search: Search|array<string,mixed>,
 *   suggestion: Suggestion|array<string,mixed>,
 *   replies: Replies|array<string,mixed>,
 *   replyLock: ReplyLock|array<string,mixed>,
 *   timeline: Timeline|array<string,mixed>,
 *   engagement: Engagement|array<string,mixed>,
 *   sensitive: Sensitive|array<string,mixed>,
 *   withheld: Withheld|array<string,mixed>,
 * }
 */
final class Checks implements BaseModel
{
    /** @use SdkModel<ChecksShape> */
    use SdkModel;

    /**
     * Passes an active or protected account & fails a suspended one.
     */
    #[Required]
    public Account $account;

    /**
     * Looks for the account's recent posts in X search, sorted by Latest. `listed` passes & `missing` fails.
     */
    #[Required]
    public Search $search;

    /**
     * Looks for the account among the accounts X suggests for its username. `suggested` passes & `not_suggested` fails.
     */
    #[Required]
    public Suggestion $suggestion;

    /**
     * Opens the threads of up to 3 recent replies to other accounts. `in_thread` passes. X ranks replies for each viewer, so `more_replies` can't tell.
     */
    #[Required]
    public Replies $replies;

    /**
     * Reads the same reply threads as `replies`. `replies_show` passes when any checked reply shows. X ranks replies for each viewer, so `replies_missing` can't tell.
     */
    #[Required]
    public ReplyLock $replyLock;

    /**
     * Looks for the account's posts on its profile timeline. `visible` passes & `hidden` fails.
     */
    #[Required]
    public Timeline $timeline;

    /**
     * Compares the newest 5 of the account's own posts older than 24 hours with its earlier posts, by the median of likes, replies, reposts & quotes. `typical` passes at 25% or more. A drop alone proves nothing, so `low` can't tell.
     */
    #[Required]
    public Engagement $engagement;

    /**
     * Reads X's sensitive flag on the profile. `not_flagged` passes & `flagged` fails.
     */
    #[Required]
    public Sensitive $sensitive;

    /**
     * Reads the countries where X withholds the account. `none` passes & `countries` fails.
     */
    #[Required]
    public Withheld $withheld;

    /**
     * `new Checks()` is missing required properties by the API.
     *
     * To enforce required parameters use
     * ```
     * Checks::with(account: ..., search: ..., suggestion: ..., replies: ..., replyLock: ..., timeline: ..., engagement: ..., sensitive: ..., withheld: ...)
     * ```
     *
     * Otherwise ensure the following setters are called
     *
     * ```
     * (new Checks)->withAccount(...)->withSearch(...)->withSuggestion(...)->withReplies(...)->withReplyLock(...)->withTimeline(...)->withEngagement(...)->withSensitive(...)->withWithheld(...)
     * ```
     */
    public function __construct()
    {
        $this->initialize();
    }

    /**
     * Construct an instance from the required parameters.
     *
     * You must use named parameters to construct any parameters with a default value.
     *
     * @param Account|array<string,mixed> $account
     * @param Search|array<string,mixed> $search
     * @param Suggestion|array<string,mixed> $suggestion
     * @param Replies|array<string,mixed> $replies
     * @param ReplyLock|array<string,mixed> $replyLock
     * @param Timeline|array<string,mixed> $timeline
     * @param Engagement|array<string,mixed> $engagement
     * @param Sensitive|array<string,mixed> $sensitive
     * @param Withheld|array<string,mixed> $withheld
     */
    public static function with(Account|array $account, Search|array $search, Suggestion|array $suggestion, Replies|array $replies, ReplyLock|array $replyLock, Timeline|array $timeline, Engagement|array $engagement, Sensitive|array $sensitive, Withheld|array $withheld): self
    {
        $self = new self;

        $self['account'] = $account;
        $self['search'] = $search;
        $self['suggestion'] = $suggestion;
        $self['replies'] = $replies;
        $self['replyLock'] = $replyLock;
        $self['timeline'] = $timeline;
        $self['engagement'] = $engagement;
        $self['sensitive'] = $sensitive;
        $self['withheld'] = $withheld;

        return $self;
    }

    /**
     * Passes an active or protected account & fails a suspended one.
     *
     * @param Account|array<string,mixed> $account
     */
    public function withAccount(Account|array $account): self
    {
        $self = clone $this;
        $self['account'] = $account;

        return $self;
    }

    /**
     * Looks for the account's recent posts in X search, sorted by Latest. `listed` passes & `missing` fails.
     *
     * @param Search|array<string,mixed> $search
     */
    public function withSearch(Search|array $search): self
    {
        $self = clone $this;
        $self['search'] = $search;

        return $self;
    }

    /**
     * Looks for the account among the accounts X suggests for its username. `suggested` passes & `not_suggested` fails.
     *
     * @param Suggestion|array<string,mixed> $suggestion
     */
    public function withSuggestion(Suggestion|array $suggestion): self
    {
        $self = clone $this;
        $self['suggestion'] = $suggestion;

        return $self;
    }

    /**
     * Opens the threads of up to 3 recent replies to other accounts. `in_thread` passes. X ranks replies for each viewer, so `more_replies` can't tell.
     *
     * @param Replies|array<string,mixed> $replies
     */
    public function withReplies(Replies|array $replies): self
    {
        $self = clone $this;
        $self['replies'] = $replies;

        return $self;
    }

    /**
     * Reads the same reply threads as `replies`. `replies_show` passes when any checked reply shows. X ranks replies for each viewer, so `replies_missing` can't tell.
     *
     * @param ReplyLock|array<string,mixed> $replyLock
     */
    public function withReplyLock(ReplyLock|array $replyLock): self
    {
        $self = clone $this;
        $self['replyLock'] = $replyLock;

        return $self;
    }

    /**
     * Looks for the account's posts on its profile timeline. `visible` passes & `hidden` fails.
     *
     * @param Timeline|array<string,mixed> $timeline
     */
    public function withTimeline(Timeline|array $timeline): self
    {
        $self = clone $this;
        $self['timeline'] = $timeline;

        return $self;
    }

    /**
     * Compares the newest 5 of the account's own posts older than 24 hours with its earlier posts, by the median of likes, replies, reposts & quotes. `typical` passes at 25% or more. A drop alone proves nothing, so `low` can't tell.
     *
     * @param Engagement|array<string,mixed> $engagement
     */
    public function withEngagement(Engagement|array $engagement): self
    {
        $self = clone $this;
        $self['engagement'] = $engagement;

        return $self;
    }

    /**
     * Reads X's sensitive flag on the profile. `not_flagged` passes & `flagged` fails.
     *
     * @param Sensitive|array<string,mixed> $sensitive
     */
    public function withSensitive(Sensitive|array $sensitive): self
    {
        $self = clone $this;
        $self['sensitive'] = $sensitive;

        return $self;
    }

    /**
     * Reads the countries where X withholds the account. `none` passes & `countries` fails.
     *
     * @param Withheld|array<string,mixed> $withheld
     */
    public function withWithheld(Withheld|array $withheld): self
    {
        $self = clone $this;
        $self['withheld'] = $withheld;

        return $self;
    }
}
